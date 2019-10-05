<?php
namespace Ateliee\PlantUMLParser;

class PUMLObject extends PUMLElementBlock
{

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string|null $alias
     */
    protected $alias = null;

    /**
     * @var string|null $attributes
     */
    protected $attributes = null;

    /**
     * @param string $type
     * @param string $name
     * @param null|string $alias
     * @param null|string $attributes
     */
    public function __construct($type, $name, $alias = null, $attributes = null)
    {
        parent::__construct($type);

        $this->name = $name;
        $this->alias = $alias;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getValueLabel()
    {
        return sprintf(
            '%s %s%s%s',
            $this->value,
            $this->alias ? "\"".$this->name."\"" : $this->name,
            $this->alias ? ' as '.$this->alias : '',
            $this->attributes ? ' '.$this->attributes : ''
        );
    }
}
