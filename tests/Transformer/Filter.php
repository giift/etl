<?php
namespace Test\Giift\Etl\Transformer;

/**
 * Test Transformer Filter
 * @author giift
 * @group Etl
 */
class Filter extends \PHPUnit_Framework_TestCase
{
    /**
     * etl configuration
     * @var array
     */
    protected $config;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->node_loader = new \Giift\Etl\Loader\Debug();
    }

    /**
     * test with fields and file with data
     * assertNotNull
     * assertNotEmpty
     * assertArrayHasKey
     * @return void
     */
    public function testWithFields()
    {
        $config = array(
            'fields' => array(
                'number' => array('points'),
                'email' => array('email'),
                'url' =>array('url')
            )
        );
        $record = array('points'=>12354, 'email'=>'giif@giift.com', 'url'=>'http://giift.com');

        $node_filter = new \Giift\Etl\Transformer\Filter($config);
        $node_filter->addOutput($this->node_loader);

        $node_filter->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test with empty fields and file with data
     * assertNotNull
     * assertNotEmpty
     * assertArrayHasKey
     * @return void
     */
    public function testEmptyFields()
    {
        $config = array('fields' => array ());
        $record = array('points'=>12354, 'email'=>'giif@giift.com');

        $node_filter = new \Giift\Etl\Transformer\Filter($config);
        $node_filter->addOutput($this->node_loader);

        $node_filter->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test with empty file and fields
     * assertNotNull result array
     * assertEmpty result array
     * @return void
     */
    public function testEmptyRecord()
    {
        $config = array('fields' => array ('number' => array('points'), 'email' => array('email')));
        $record = array();

        $node_filter = new \Giift\Etl\Transformer\Filter($config);
        $node_filter->addOutput($this->node_loader);

        $node_filter->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        foreach ($rs as $result) {
            $this->assertEmpty($result);
        }
    }

    /**
     * Test empty both array
     * assertNotNull
     * assertEmpty
     * @return void
     */
    public function testEmptyArray()
    {
        $config = array();
        $record = array();

        $node_filter = new \Giift\Etl\Transformer\Filter($config);
        $node_filter->addOutput($this->node_loader);

        $node_filter->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        foreach ($rs as $result) {
            $this->assertEmpty($result);
        }
    }
}
