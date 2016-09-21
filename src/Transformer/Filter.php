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
     * @param array $config,
     *          fields array from config
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
     * @param array $record, single array from single line of the file
     */
    public function processRecord(array $record)
    {
        if (!empty($this->id_field)) {
            foreach ($this->id_field as $key => $field_arr) {
                foreach ($field_arr as $field) {
                    if (!empty($record [$field])) {
                        // call function base on key value, exp: filter_number
                        $fnc = 'filter_' . $key;
                        $record [$field] = self::$fnc($record [$field]);
                    }
                }
            }
        }

        $res = $this->sendNextStep($record);

        return $res;
    }

    /**
     * Filter weird characters left only clean number
     *
     * @param string $value
     * @return string
     */
    public static function filter_number($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * Filter email
     * @param string $value
     * @return string
     */
    public static function filter_email($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $value;
        } else {
            \Giift\Etl\Log::instance()->error('ETL | email', 'Removed bad email: '.$value);
            return '';
        }
    }

    /**
     * Filter URL
     * @param string $value
     * @return string
     */
    public static function filter_url($value)
    {
        $value = filter_var($value, FILTER_SANITIZE_URL);
        if (!filter_var($value, FILTER_VALIDATE_URL) === false) {
            return $value;
        } else {
            \Giift\Etl\Log::instance()->error('ETL | url', 'Removed bad url: '.$value);
            return '';
        }
    }
}
