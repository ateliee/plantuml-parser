<?php
namespace Ateliee\PlantUMLParser;

/**
 * Class PUMLParser
 */
class PUMLParser{

    /**
     * @var PUMLElementList $root_element
     */
    protected $root = null;

    /**
     * PUMLParser constructor.
     */
    public function __construct()
    {
        $this->root = new PUMLElementList();
    }

    /**
     * @return PUMLElementList
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Read Str
     *
     * @param string $str
     * @todo
     */
    public function parse($str){
    }

    /**
     * @param int $indent
     * @return string
     */
    public function output($indent = 2){

        $setting = new PUMLSetting($indent);
        $this->root->setSetting($setting);

        $str = '@startuml'.PHP_EOL;
        $str .= $this->root.PHP_EOL;
        $str .= '@enduml';
        return $str;
    }
}
