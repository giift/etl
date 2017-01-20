<?php
namespace Giift\Etl\Transformer;

/**
 * Transforms data by replace with new value
 * this class extends Node class
 *
 * @author giift
 */
class Replace extends \Giift\Etl\Node
{
    /**
     * List of field to add to data
     *
     * @var array
     */
    private $id_field = array ();

    private $subject_field = array();

    /**
     * Constructor
     *
     * @param array $config Fields array from config.
     */
    public function __construct(array $config = array())
    {
        parent::__construct($config);
        $this->id_field = (isset($config['fields']) && is_array($config['fields'])) ? $config['fields'] : array();
        $this->subject_field = (isset($config['subject_field']) && is_array($config['subject_field'])) ?
            $config['subject_field'] : array();
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
        $replace_find = array();
        $replace_with = array();
        foreach (array_keys($this->id_field) as $key) {
            $replace_find [] = '%' . $key . '%';
            $replace_with [] = $record [$this->id_field [$key]];
        }

        foreach ($this->subject_field as $subject) {
            if (isset($record[$subject]) && !empty($record[$subject])) {
                $record[$subject] = str_replace($replace_find, $replace_with, $record[$subject]);
            }
        }

        return $this->sendNextStep($record);
    }
}
