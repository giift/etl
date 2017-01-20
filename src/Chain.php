<?php
namespace Giift\Etl;

/**
 * class chain, build ETL chain
 *
 * @author giift
 *
 */
class Chain
{
    /**
     * Nodes run first and next
     *
     * @var object
     */
    private $init_node_ = null;

    /**
     * Nodes from config
     *
     * @var array
     */
    // private $nodes_config_ = array();
    private $nodes_arr = array();

    /**
     * constructor
     */
    private function __construct()
    {
    }

    /**
     * Function forge, start of the chain building call
     *
     * @param array $config Whole array found in config\etl.php.
     * @return \Giift\Etl\Chain
     */
    public static function forge(array $config)
    {
        $nodes_config = (isset($config['nodes']) && is_array($config['nodes'])) ? $config['nodes'] : array();
        $res = new Chain();

        $init_node_id = (isset($config['init_node']) && is_string($config['init_node'])) ? $config['init_node'] : '';
        $res->init($nodes_config, $init_node_id);

        return $res;
    }

    /**
     * Function init, create node array and init node
     *
     * @param array  $nodes_config Array representation of the chain.
     * @param string $init_node_id Entry point node of the chain.
     * @return void
     */
    protected function init(array $nodes_config, $init_node_id)
    {
        $node = null;
        foreach ($nodes_config as $name => $node) {
            $type = (isset($node['type']) && is_string($node['type'])) ? $node['type'] : '';
            $class = (isset($node['class']) && is_string($node['class'])) ? $node['class'] : '';

            $node_obj = \Giift\Etl\Node::forge($class, $type, $node);
            if (!is_null($node_obj)) {
                $this->nodes_arr[$name] = $node_obj;
            } else {
                \Giift\Etl\Log::instance()->error('Node does not exist :'.$class.'/'.$type);
            }
        }

        $this->init_node_ = $this->nodes_arr[$init_node_id];
        $this->init_node_->link($this);
    }

    /**
     * Get node from its id.
     * @param string $id Id of the node.
     * @return array|null
     */
    public function getNode($id)
    {
        return isset($this->nodes_arr[$id]) ? $this->nodes_arr[$id] : null;
    }

    /**
     * Function run, start run the chain
     * extract() is the extract function in extractor
     * @return string
     */
    public function run()
    {
        return $this->init_node_->extract();
    }
}
