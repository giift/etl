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
     */
    public function __construct(array $config = null)
    {
    }

    /**
     * Output the result, save to static array
     *
     * @see \Etl\Node::processRecord()
     * @param array $record,
     *          single array from single line of csv
     */
    public function processRecord(array $record)
    {
        if (!empty($record)) {
            $this->result[] = $record;
        }
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
