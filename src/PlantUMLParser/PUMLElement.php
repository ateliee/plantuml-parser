<?php
namespace Ateliee\PlantUMLParser;

/**
 * Class PUMLParser
 */
class PUMLElement{

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string|null $alias
     */
    protected $alias = null;

    /**
     * @var PUMLElement[] $childs
     */
    protected $childs = null;

    /**
     * @param string $name
     * @param null|string $alias
     */
    public function __construct($name, $alias = null)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->childs = [];
    }
}
