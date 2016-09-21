<?php
namespace Test\Giift\Etl;

/**
 * @group Etl
 */
class Chain extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Test chain of transformer
     * Verify node being initialize
     * Verify output node is correct class
     */
    public function testChain()
    {
        $config = array (
            'init_node' => 'extractor',
            'nodes' => array (
                'extractor' => array (
                    'class' => 'extractor',
                    'type' => 'csv',
                    'output' => array ('mapi'),
                    'file' => 'etl/tests/csv/email.csv',
                    'skip_lines' => 1,
                    'header_line' => -1
                ),
                'mapi' => array (
                    'class' => 'transformer',
                    'type' => 'map',
                    'output' => array ('filter_node'),
                ),
                'filter_node' => array (
                    'class' => 'transformer',
                    'type' => 'filter',
                    'output' => array ('add_field'),
                ),
                'add_field' => array (
                    'class' => 'transformer',
                    'type' => 'add_field',
                    'output' => array ('if'),
                ),
                'if' => array (
                    'class' => 'transformer',
                    'type' => 'conditional_if',
                    'output' => array ('replace'),
                ),
                'replace' => array (
                    'class' => 'transformer',
                    'type' => 'replace',
                    'output' => array ('loader'),
                ),
                'loader' => array (
                    'class' => 'loader',
                    'type' => 'debug'
                )
            ));

        $etl = \Giift\Etl\Chain::forge($config);

        $extractor = $etl->getNode('extractor');
        $this->assertNotEmpty($extractor);
        $extractor_output = $extractor->getOutputs();
        foreach ($extractor_output as $output) {
            $this->assertEquals('Giift\\Etl\\Transformer\\Map', get_class($output));
        }

        $map = $etl->getNode('mapi');
        $this->assertNotEmpty($map);
        $map_output = $map->getOutputs();
        foreach ($map_output as $output) {
            $this->assertEquals('Giift\\Etl\\Transformer\\Filter', get_class($output));
        }

        $filter = $etl->getNode('filter_node');
        $this->assertNotEmpty($filter);
        $filter_output = $filter->getOutputs();
        foreach ($filter_output as $output) {
            $this->assertEquals('Giift\\Etl\\Transformer\\AddField', get_class($output));
        }

        $addfield = $etl->getNode('add_field');
        $this->assertNotEmpty($addfield);
        $addfield_output = $addfield->getOutputs();
        foreach ($addfield_output as $output) {
            $this->assertEquals('Giift\\Etl\\Transformer\\ConditionalIf', get_class($output));
        }

        $if = $etl->getNode('if');
        $this->assertNotEmpty($if);
        $if_output = $if->getOutputs();
        foreach ($if_output as $output) {
            $this->assertEquals('Giift\Etl\Transformer\Replace', get_class($output));
        }

        $replace = $etl->getNode('replace');
        $this->assertNotEmpty($replace);
        $replace_output = $replace->getOutputs();
        foreach ($replace_output as $output) {
            $this->assertEquals('Giift\Etl\Loader\Debug', get_class($output));
        }
    }

    /**
     * Test chain not broken
     * Verify node being initialize
     * Verify output node is correct class
     */
    public function testCrazyNode()
    {
        $config = array (
            'init_node' => 'extractor',
            'nodes' => array (
                'extractor' => array (
                    'class' => 'extractor',
                    'type' => 'csv',
                    'output' => array ('mapi'),
                    'file' => 'etl/tests/csv/email.csv',
                    'skip_lines' => 1,
                    'header_line' => -1
                ),
                'mapi' => array (
                    'class' => 'transformer',
                    'type' => 'map',
                    'output' => array ('filter_node'),
                ),
                'filter_node' => array (
                    'class' => 'transformer',
                    'type' => 'filter',
                    'output' => array ('add_field'),
                ),
                'add_field' => array (
                    'class' => 'transformer',
                    'type' => 'add_field',
                    'output' => array ('mapi'),
                )
            ));

        $etl = \Giift\Etl\Chain::forge($config);

        $extractor = $etl->getNode('extractor');
        $this->assertNotEmpty($extractor);
        $extractor_output = $extractor->getOutputs();
        foreach ($extractor_output as $output) {
            $this->assertEquals('Giift\Etl\Transformer\Map', get_class($output));
        }

        $map = $etl->getNode('mapi');
        $this->assertNotEmpty($map);
        $map_output = $map->getOutputs();
        foreach ($map_output as $output) {
            $this->assertEquals('Giift\Etl\Transformer\Filter', get_class($output));
        }

        $filter = $etl->getNode('filter_node');
        $this->assertNotEmpty($filter);
        $filter_output = $filter->getOutputs();
        foreach ($filter_output as $output) {
            $this->assertEquals('Giift\Etl\Transformer\AddField', get_class($output));
        }

        $addfield = $etl->getNode('add_field');
        $this->assertNotEmpty($addfield);
        $addfield_output = $addfield->getOutputs();
        foreach ($addfield_output as $output) {
            $this->assertEquals('Giift\Etl\Transformer\Map', get_class($output));
        }
    }

    /**
     * Test chain not broken, multi link
     * Verify node being initialize
     * Verify output node is correct class
     */
    public function testCrazyNode2()
    {
        $config = array (
            'init_node' => 'extractor',
            'nodes' => array (
                'extractor' => array (
                    'class' => 'extractor',
                    'type' => 'csv',
                    'output' => array ('filter_node'),
                    'file' => 'etl/tests/csv/email.csv',
                    'skip_lines' => 1,
                    'header_line' => -1
                ),
                'mapi' => array (
                    'class' => 'transformer',
                    'type' => 'map',
                    'output' => array ('replace'),
                ),
                'replace' => array (
                    'class' => 'transformer',
                    'type' => 'replace',
                    'output' => array ('add_field'),
                ),
                'filter_node' => array (
                    'class' => 'transformer',
                    'type' => 'filter',
                    'output' => array ('mapi', 'add_field'),
                ),
                'add_field' => array (
                    'class' => 'transformer',
                    'type' => 'add_field',
                    'output' => array ('mapi', 'filter_node'),
                ),
            ));

        $etl = \Giift\Etl\Chain::forge($config);

        $extractor = $etl->getNode('extractor');
        $this->assertNotEmpty($extractor);
        $extractor_output = $extractor->getOutputs();
        foreach ($extractor_output as $output) {
            $this->assertEquals('Giift\Etl\Transformer\Filter', get_class($output));
        }

        $filter = $etl->getNode('filter_node');
        $this->assertNotEmpty($filter);
        $filter_output = $filter->getOutputs();
        foreach ($filter_output as $output) {
            if (is_a($output, 'Transformer_Filter')) {
                $this->assertEquals('Giift\Etl\Transformer\AddField', get_class($output));
            }
            if (is_a($output, 'Transformer_Map')) {
                $this->assertEquals('Giift\Etl\Transformer\Map', get_class($output));
            }
        }

        $map = $etl->getNode('mapi');
        $this->assertNotEmpty($map);
        $map_output = $map->getOutputs();
        foreach ($map_output as $output) {
            $this->assertEquals('Giift\Etl\Transformer\Replace', get_class($output));
        }

        $replace = $etl->getNode('replace');
        $this->assertNotEmpty($replace);
        $replace_output = $replace->getOutputs();
        foreach ($replace_output as $output) {
            $this->assertEquals('Giift\Etl\Transformer\AddField', get_class($output));
        }

        $addfield = $etl->getNode('add_field');
        $this->assertNotEmpty($addfield);
        $addfield_output = $addfield->getOutputs();
        foreach ($addfield_output as $output) {
            if (is_a($output, 'Transformer_Filter')) {
                $this->assertEquals('Giift\Etl\Transformer\Filter', get_class($output));
            }
            if (is_a($output, 'Transformer_Map')) {
                $this->assertEquals('Giift\Etl\Transformer\Map', get_class($output));
            }
        }
    }

    /**
     * Test chain not broken with empty node in chain
     * Verify node being initialize
     * Verify output node is correct class
     */
    public function testEmptyNode()
    {
        $config = array (
            'init_node' => 'extractor',
            'nodes' => array (
                'extractor' => array (
                    'class' => 'extractor',
                    'type' => 'csv',
                    'output' => array ('empty_node'),
                    'file' => realpath(dirname(__FILE__)).'/csv/aisasia_miles.csv',
                    'skip_lines' => 1,
                    'header_line' => 0
                ),
                'empty_node' => array (
                    'class' => '',
                    'type' => '',
                    'output' => array ('loader'),
                    'fields' => ''
                ),
                'loader' => array (
                    'class' => 'loader',
                    'type' => 'debug'
                )
            )
        );

        $etl = \Giift\Etl\Chain::forge($config);

        $extractor = $etl->getNode('extractor');
        $this->assertNotEmpty($extractor);
        $extractor_output = $extractor->getOutputs();
        foreach ($extractor_output as $output) {
            $this->assertEquals('Etl\Transformer_Get_location', get_class($output));
        }

        $etl->run();

        $rs = $etl->getNode('loader')->getResult();

        $this->assertNotNull($rs);
        $this->assertEmpty($rs);
    }
}
