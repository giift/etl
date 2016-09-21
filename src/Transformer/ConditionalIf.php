<?php
namespace Giift\Etl\Transformer;

/**
 * Transforms Conditional If
 * this class extends Node class
 *
 * @author giift
 */
class ConditionalIf extends \Giift\Etl\Node
{
    /**
     * List of field for conditional statement
     *
     * @var array
     */
    private $id_field = array();

    /**
     * constructor
     *
     * @param array $config, fields array from config
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
     * @param array $record
     */
    public function processRecord(array $record)
    {
        $res = '';
        if (! empty($this->id_field)) {
            $statements = $this->id_field['statement'];
            $result = false;
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    if (isset($record[$statement['field']])) {
                        switch ($statement['operator']) {
                            //equal
                            case '==':
                                if ($record[$statement['field']] == $statement['condition']) {
                                    $result = true;
                                }
                                break;
                            //identical
                            case '===':
                                if ($record[$statement['field']] === $statement['condition']) {
                                    $result = true;
                                }
                                break;
                            //Not equal
                            case '!=':
                                if ($record[$statement['field']] != $statement['condition']) {
                                    $result = true;
                                }
                                break;
                            //Not equal
                            case '<>':
                                if ($record[$statement['field']] <> $statement['condition']) {
                                    $result = true;
                                }
                                break;
                            //Not identical
                            case '!==':
                                if ($record[$statement['field']] !== $statement['condition']) {
                                    $result = true;
                                }
                                break;
                            //Less than
                            case '<':
                                if ($record[$statement['field']] < $statement['condition']) {
                                    $result = true;
                                }
                                break;
                            //Greater than
                            case '>':
                                if ($record[$statement['field']] > $statement['condition']) {
                                    $result = true;
                                }
                                break;
                            //Less than or equal to
                            case '<=':
                                if ($record[$statement['field']] <= $statement['condition']) {
                                    $result = true;
                                }
                                break;
                            //Greater than or equal to
                            case '>=':
                                if ($record[$statement['field']] >= $statement['condition']) {
                                    $result = true;
                                }
                                break;
                        }
                    }
                }
            }

            if ($result) {
                if (isset($this->id_field['next']['true'])) {
                    $res = $this->sendNextStep($record, $this->id_field['next']['true']);
                } else {
                    $res = "Conditional if true: "
                    .$statement['field']." ". $statement['operator']." ".$statement['condition'];
                }
            } elseif (!$result) {
                if (isset($this->id_field['next']['false'])) {
                    $res = $this->sendNextStep($record, $this->id_field['next']['false']);
                } else {
                    $res = "Conditional if false: "
                    .$statement['field']." ". $statement['operator']." ".$statement['condition'];
                }
            }
        }

        return $res;
    }
}
