<?php
namespace Giift\Etl\Loader;

/**
 * Loader for unit test debugging
 *
 * @author giift
 */
class Debug extends \Giift\Etl\Node
{
    public $result = array();

    /**
     * constructor
     * @param array $config Fields array from config.
     */
    public function __construct(array $config = array())
    {
        parent::__construct($config);
    }

    /**
     * Output the result, save to static array
     *
     * @see \Etl\Node::processRecord()
     * @param array $record Single array from single line of csv.
     * @return string
     */
    public function processRecord(array $record)
    {
        if (!empty($record)) {
            $this->result[] = $record;
        }
        return '';
    }

    /**
     * Function get_result
     * @return array $result
     */
    public function getResult()
    {
        return $this->result;
    }
}
