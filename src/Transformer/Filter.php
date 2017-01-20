<?php
namespace Giift\Etl\Transformer;

/**
 * Transforms add filter
 * this class extends Node class
 *
 * @author giift
 */
class Filter extends \Giift\Etl\Node
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
        if (!empty($this->id_field)) {
            foreach ($this->id_field as $key => $field_arr) {
                foreach ($field_arr as $field) {
                    if (!empty($record [$field])) {
                        // call function base on key value, exp: filter_number
                        $fnc = 'filter_' . $key;
                        if (method_exists($this, $fnc)) {
                            $record [$field] = self::$fnc($record [$field]);
                        } else {
                            \Giift\Etl\Log::instance()->error("Filter $key does not exists");
                        }
                    }
                }
            }
        }

        return $this->sendNextStep($record);
    }

    /**
     * Filter weird characters left only clean number
     *
     * @param string $value Value to be filtered.
     * @return string
     */
    public static function filterNumber($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * Filter email
     * @param string $value Value to be filtered.
     * @return string
     */
    public static function filterEmail($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $value;
        }
        \Giift\Etl\Log::instance()->notice('ETL | email', 'Removed bad email: '.$value);
        return '';
    }

    /**
     * Filter URL
     * @param string $value Value to be filtered.
     * @return string
     */
    public static function filterUrl($value)
    {
        $value = filter_var($value, FILTER_SANITIZE_URL);
        if (!filter_var($value, FILTER_VALIDATE_URL) === false) {
            return $value;
        }
        \Giift\Etl\Log::instance()->notice('ETL | url', 'Removed bad url: '.$value);
        return '';
    }
}
