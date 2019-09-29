<?php
namespace Ateliee\PlantUMLParser;

/**
 * @property PUMLElementList $value
 */
class PUMLElementBlock extends PUMLElement implements \ArrayAccess {

    /**
     * @var string $type
     */
    protected $type;

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
        parent::__construct(new PUMLElementList());

        $this->type = $type;
        $this->name = $name;
        $this->alias = $alias;
        $this->attributes = $attributes;
    }

    /**
     * @param PUMLElement $elm
     * @return $this
     */
    public function add($elm){
        $this->value->add($elm);
        return $this;
    }

    /**
     * @param string $current_indent
     * @param int $indent
     * @return string
     */
    public function str($current_indent, $indent)
    {
        $str = $this->getOutputComment($current_indent);
        $str .= $current_indent.sprintf('%s %s%s%s{',
                $this->type,
                $this->alias ? "\"".$this->name."\"" : $this->name,
                $this->alias ? ' as '.$this->alias : '',
                $this->attributes ? ' '.$this->attributes : ''
            ).PHP_EOL;
        $str .= $this->value->str($current_indent.$this->make_indent($indent), $indent);
        $str .= $current_indent.'}';
        if(!$current_indent){
            $str .= PHP_EOL;
        }
        return $str;
    }


    public function offsetExists($offset)
    {
        return isset($this->value[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->value[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->value[] = $value;
        } else {
            $this->value[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->value[$offset]);
    }


}
