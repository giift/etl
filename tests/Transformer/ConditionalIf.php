<?php
namespace Test\Giift\Etl\Transformer;

/**
 * Test Transformer_Conditional_if
 * @author giift
 * @group Etl
 */
class ConditionalIf extends \PHPUnit_Framework_TestCase
{
    /**
     * Loader debug class
     * @var object class
     */
    protected $node_loader;

    protected function setUp()
    {
        parent::setUp();

        $this->node_loader = new \Giift\Etl\Loader\Debug();
    }

    /**
     * Test empty record
     * assertNotNull
     * assertEmpty
     */
    public function testEmptyVar()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'==', 'condition'=>'')
                                            ),
                                    'next'=>array('true'=>'0')
                            ));
        $record = array();

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }

    /**
     * Test empty statement
     * assertNotNull
     * assertEmpty
     */
    public function testEmptyStatement()
    {
        $config = array('fields' => array ('statement'=>array(),
                                    'next'=>array('true'=>'0')
                            ));
        $record = array('name'=>'test');

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }

    /**
     * test operator ==
     * assertNotNull
     * assertNotEmpty
     */
    public function testOperatorA()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'==', 'condition'=>'')
                                            ),
                                    'next'=>array('false'=>'0')
                            ));
        $record = array('name'=>'test');

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test operator !=
     * assertNotNull
     * assertNotEmpty
     */
    public function testOperatorb()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'!=', 'condition'=>'')
                                            ),
                                    'next'=>array('true'=>'0')
                            ));
        $record = array('name'=>'test');

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test operator ===
     * assertNotNull
     * assertNotEmpty
     */
    public function testOperatorc()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'===', 'condition'=>'')
                                            ),
                                    'next'=>array('false'=>'0')
                            ));
        $record = array('name'=>'test');

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test operator <>
     * assertNotNull
     * assertNotEmpty
     */
    public function testOperatord()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'<>', 'condition'=>'')
                                            ),
                                    'next'=>array('true'=>'0')
                            ));
        $record = array('name'=>'test');

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test operator !==
     * assertNotNull
     * assertNotEmpty
     */
    public function testOperatore()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'!==', 'condition'=>'')
                                            ),
                                    'next'=>array('true'=>'0')
                            ));
        $record = array('name'=>'test');

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test operator <
     * assertNotNull
     * assertNotEmpty
     */
    public function testOperatorf()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'<', 'condition'=>1)
                                            ),
                                    'next'=>array('true'=>'0')
                            ));
        $record = array ('name'=>0);

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test operator >
     * assertNotNull
     * assertNotEmpty
     */
    public function testOperatorg()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'>', 'condition'=>1)
                                            ),
                                    'next'=>array('false'=>'0')
                            ));
        $record = array ('name'=>0);

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test operator <=
     * assertNotNull
     * assertNotEmpty
     */
    public function testOperatorh()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'<=', 'condition'=>1)
                                            ),
                                    'next'=>array('true'=>'0')
                            ));
        $record = array ('name'=>0);

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * test operator >=
     * assertNotNull
     * assertNotEmpty
     */
    public function testOperatori()
    {
        $config = array('fields' => array ('statement'=>array(
                                            array('field'=>'name', 'operator'=>'>=', 'condition'=>1)
                                            ),
                                    'next'=>array('false'=>'0')
                            ));
        $record = array ('name'=>0);

        $node_if = new \Giift\Etl\Transformer\ConditionalIf($config);
        $node_if->addOutput($this->node_loader);

        $node_if->processRecord($record);

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }
}
