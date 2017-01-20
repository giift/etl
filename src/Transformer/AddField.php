<?php
namespace Giift\Etl\Transformer;

/**
 * Transforms add field
 * this class extends Node class
 *
 * @author giift
 */
class AddField extends \Giift\Etl\Node
{
    /**
     * List of field to add to data
     *
     * @var array
     */
    private $id_field = array();

    /**
     * constructor
     *
     * @param array $config Fields array from config.
     */
    public function __construct(array $config = array())
    {
        parent::__construct($config);
        $this->id_field = (isset($config['fields']) && is_array($config['fields'])) ? $config['fields'] : array();
    }

    /**
     * proceed next step
     *
     * @see \Etl\Node::processRecord()
     * @param array $record Single array from single line of the file.
     * @return string
     */
    public function processRecord(array $record)
    {
        $data = array_merge($record, $this->id_field);
        $res = $this->sendNextStep($data);

        return $res;
    }
}
