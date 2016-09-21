<?php
namespace Giift\Etl\Extractor;

/**
 * Extracts data from homogeneous or heterogeneous data sources
 * this class extends Node class
 *
 * @author giift
 */
class Csv extends \Giift\Etl\Node
{
    /**
     * Path of the file
     *
     * @var string
     */
    private $path;

    /**
     *  Number of line to skip before start process extraction
     *
     * @var int
     */
    private $skip_line;

    /**
     * Position of header in which line
     *
     * @var int
     */
    private $header_line;

    /**
     * constructor
     *
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        parent::__construct($config);
        $this->path = $config['file'];
        $this->skip_line = $config['skip_lines'];
        $this->header_line = $config['header_line'];
    }

    /**
     * Function extract
     * Open file, read file, extract line by line of the file
     */
    public function extract()
    {
        // $lineseparator = "\n";

        if (!file_exists($this->path)) {
            throw new \Exception(
                "File not found. Make sure you specified the correct path.\n".print_r($this->path, true)."\n"
            );
        }

        $file = fopen($this->path, "r");

        if (!$file) {
            throw new \Exception("Error opening data file - ".$this->path);
        }

        $size = filesize($this->path);

        if (!$size) {
            throw new \Exception("File is empty.\n");
        }

        $res_array = array();
        //read the file
        $row = 0;
        while ($data = fgetcsv($file, 0, ",")) {
        //set header row
            if ($this->header_line >= 0 && $row == $this->header_line) {
                $header = $data;
            }
            if ($this->skip_line == 0 || $row >= $this->skip_line) {
                if ($this->header_line < 0) {
                    //ignore blank lines
                    if (array(null) !== $data) {
                        $res = $this->sendNextStep($data);
                        if (is_string($res)) {
                            $res_array[] = $res;
                        }
                    }
                } elseif ($this->header_line >= 0) {
                    //ignore blank lines
                    if (array(null) !== $data) {
                    //merge header become array key
                        $data_combine = array();
                        foreach ($header as $index => $key) {
                            $key = trim($key);
                            if (!empty($key)) {
                                $data_combine[$key] = isset($data[$index]) ? $data[$index] : null;
                            } else {
                                $data_combine[$index] = isset($data[$index]) ? $data[$index] : null;
                            }
                        }

                        if (!empty($data_combine)) {
                            $res = $this->sendNextStep($data_combine);
                            if (is_string($res)) {
                                $res_array[] = $res;
                            }
                        }
                    }
                }
            }
            $row++;
        }

        fclose($file);

        return $res_array;
    }

    /**
     * @see \Etl\Node::processRecord()
     * @param array $record, single array from single line of csv
     */
    public function processRecord(array $record)
    {
    }
}
