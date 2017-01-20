<?php
namespace Test\Giift\Etl\Transformer;

/**
 * Test Transformer_Add_field
 * @author giift
 * @group Etl
 */
class AddField extends \PHPUnit_Framework_TestCase
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
     * Test with fields array
     * Empty record array
     * assertNotNull
     * assertNotEmpty
     * assertArrayHasKey
     * assertContains
     * @return void
     */
    public function testWithFields()
    {
        $config = array('fields' => array('retailer_id' => '1416979169n9aCc'));
        $record = array();

        $node_addfield = new \Giift\Etl\Transformer\AddField($config);
        $node_addfield->addOutput($this->node_loader);

        $node_addfield->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
        foreach ($rs as $result) {
            $this->assertArrayHasKey('retailer_id', $result);
            $this->assertContains('1416979169n9aCc', $result);
        }
    }

    /**
     * Test with empty fields array
     * Empty record array
     * assertNotNull
     * assertNotEmpty
     * @return void
     */
    public function testEmptyfields()
    {
        $config = array('fields' => array());
        $record = array();

        $node_addfield = new \Giift\Etl\Transformer\AddField($config);
        $node_addfield->addOutput($this->node_loader);

        $node_addfield->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }

    /**
     * Test with both empty array
     * assertNotNull
     * assertNotEmpty
     * @return void
     */
    public function testEmptyArray()
    {
        $config = array();
        $record = array();

        $node_addfield = new \Giift\Etl\Transformer\AddField($config);
        $node_addfield->addOutput($this->node_loader);

        $node_addfield->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }
}
