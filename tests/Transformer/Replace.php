<?php
namespace Test\Giift\Etl\Transformer;

/**
 * Transformer_Replace
 * @author giift
 * @group Etl
 */
class Replace extends \PHPUnit_Framework_TestCase
{
    /**
     * Loader debug class
     * @var object class
     */
    protected $node_loader;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->node_loader = new \Giift\Etl\Loader\Debug();
    }

    /**
     * Test with fields and record
     * assertNotNull
     * assertNotEmpty
     * assertArrayHasKey
     * assertEquals
     * @return void
     */
    public function testWithFileFields()
    {
        $config = array(
            'subject_field' => array('description'),
            'fields' => array ('origin' => 'From','destination' => 'To','price' => 'Miles')
        );
        $record = array(
            'From'=>'Singapore',
            'To'=>'London',
            'Miles'=>'12000',
            'description' => 'Flight From %origin% To %destination% for %price% miles'
        );

        $node_replace = new \Giift\Etl\Transformer\Replace($config);
        $node_replace->addOutput($this->node_loader);

        $node_replace->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
        foreach ($rs as $result) {
            $this->assertArrayHasKey('From', $result);
            $this->assertArrayHasKey('Miles', $result);
            $this->assertEquals("Flight From Singapore To London for 12000 miles", $result['description']);
        }
    }

    /**
     * Test with empty fields array and record not empty
     * assertNotNull
     * assertNotEmpty
     * assertNotEquals
     * @return void
     */
    public function testEmptyField()
    {
        $config = array('subject_field' => array('description'), 'fields' => array ());
        $record = array(
            'From'=>'Singapore',
            'To'=>'London', 'Miles'=>'12000',
            'description' => 'Flight From %origin% To %destination% for %price% miles'
        );

        $node_replace = new \Giift\Etl\Transformer\Replace($config);
        $node_replace->addOutput($this->node_loader);

        $node_replace->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
        foreach ($rs as $result) {
            $this->assertNotEquals("Flight From Singapore To London for 12000 miles", $result['description']);
        }
    }

    /**
     * Test withfields array and record empty
     * assertNotNull
     * assertEmpty
     * @return void
     */
    public function testEmptyRecord()
    {
        $config = array('subject_field' => array('description'), 'fields' => array ());
        $record = array();

        $node_replace = new \Giift\Etl\Transformer\Replace($config);
        $node_replace->addOutput($this->node_loader);

        $node_replace->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }

    /**
     * Test with empty both
     * assertNotNull
     * assertEmpty
     * @return void
     */
    public function testBothEmpty()
    {
        $config = array();
        $record = array();

        $node_replace = new \Giift\Etl\Transformer\Replace($config);
        $node_replace->addOutput($this->node_loader);

        $node_replace->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }
}
