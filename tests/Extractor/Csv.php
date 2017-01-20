<?php
namespace Test\Giift\Etl\Extractor;

/**
 * Test extractor csv
 * @author giift
 * @group Etl
 */
class Csv extends \PHPUnit_Framework_TestCase
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
     * Test with file
     * assertNotNull
     * assertNotEmpty
     * @return void
     */
    public function testWithFile()
    {
        $config = array(
            'file' => realpath(dirname(__FILE__)).'/../csv/email.csv',
            'skip_lines' => 1,
            'header_line' => -1
        );

        $node_csv = new \Giift\Etl\Extractor\Csv($config);
        $node_csv->addOutput($this->node_loader);

        $node_csv->extract();

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * Test with empty file
     * assertNotNull
     * assertEmpty
     * @return void
     */
    public function testWithEmptyFile()
    {
        $config = array(
            'file' => realpath(dirname(__FILE__)).'/../csv/empty.csv',
            'skip_lines' => 1,
            'header_line' => -1
        );

        $node_csv = new \Giift\Etl\Extractor\Csv($config);
        $node_csv->addOutput($this->node_loader);

        $node_csv->extract();

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }

    /**
     * Test with file, empty skip line
     * assertNotNull
     * assertNotEmpty
     * @return void
     */
    public function testEmptySkipLines()
    {
        $config = array(
            'file' => realpath(dirname(__FILE__)).'/../csv/email.csv',
            'skip_lines' => '',
            'header_line' => -1
        );

        $node_csv = new \Giift\Etl\Extractor\Csv($config);
        $node_csv->addOutput($this->node_loader);

        $node_csv->extract();

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * Test with file, empty header line
     * assertNotNull
     * assertNotEmpty
     * @return void
     */
    public function testEmptyHeaderLines()
    {
        $config = array(
            'file' => realpath(dirname(__FILE__)).'/../csv/email.csv',
            'skip_lines' => 1,
            'header_line' => ''
        );

        $node_csv = new \Giift\Etl\Extractor\Csv($config);
        $node_csv->addOutput($this->node_loader);

        $node_csv->extract();

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }

    /**
     * Test with file, empty both line
     * assertNotNull
     * assertNotEmpty
     * @return void
     */
    public function testEmptyBoth()
    {
        $config = array(
            'file' => realpath(dirname(__FILE__)).'/../csv/email.csv',
            'skip_lines' => '',
            'header_line' => ''
        );

        $node_csv = new \Giift\Etl\Extractor\Csv($config);
        $node_csv->addOutput($this->node_loader);

        $node_csv->extract();

        $rs = $this->node_loader->getResult();

        $this->assertNotNull($rs);
        $this->assertNotEmpty($rs);
    }
}
