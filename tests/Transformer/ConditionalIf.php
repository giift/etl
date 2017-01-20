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

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->node_loader = new \Giift\Etl\Loader\Debug();
    }

    /**
     * Test empty record
     * assertNotNull
     * assertEmpty
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
