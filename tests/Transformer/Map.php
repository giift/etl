<?php
namespace Test\Giift\Etl\Transformer;

/**
 * Test Transformer_Map
 * @author giift
 * @group Etl
 */
class Mapping extends \PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->node_loader = new \Giift\Etl\Loader\Debug();
    }

    /**
     * Test with fields array and record
     * assertNotNull
     * assertNotEmpty
     * assertArrayHasKey
     * @return void
     */
    public function testWithMap()
    {
        $config = array('map' => array ('From' => 'Depart','To' => 'Arrive','Miles' => 'Points'));
        $record = array('From'=>'Singapore', 'To'=>'London', 'Miles'=>'12000');

        $node_mapping = new \Giift\Etl\Transformer\Map($config);
        $node_mapping->addOutput($this->node_loader);

        $node_mapping->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
        foreach ($rs as $result) {
            $this->assertArrayHasKey('Depart', $result);
            $this->assertArrayHasKey('Points', $result);
        }
    }

    /**
     * Test with empty map fields array and record not empty
     * assertNotNull
     * assertEmpty
     * @return void
     */
    public function testEmptyMap()
    {
        $config = array('map' => '');
        $record = array('From'=>'Singapore', 'To'=>'London', 'Miles'=>'12000');

        $node_mapping = new \Giift\Etl\Transformer\Map($config);
        $node_mapping->addOutput($this->node_loader);

        $node_mapping->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }

    /**
     * Test with fields and record empty
     * assertNotNull
     * assertEmpty
     * @return void
     */
    public function testEmptyRecord()
    {
        $config = array('map' => array ('From' => 'Depart','To' => 'Arrive','Miles' => 'Points'));
        $record = array();

        $node_mapping = new \Giift\Etl\Transformer\Map($config);
        $node_mapping->addOutput($this->node_loader);

        $node_mapping->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }

    /**
     * Test with empty fields array and record empty
     * assertNotNull
     * assertEmpty
     * @return void
     */
    public function testEmptyBoth()
    {
        $config = array();
        $record = array();

        $node_mapping = new \Giift\Etl\Transformer\Map($config);
        $node_mapping->addOutput($this->node_loader);

        $node_mapping->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        foreach ($rs as $result) {
            $this->assertEmpty($result);
        }
    }
}
