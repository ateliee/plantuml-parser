<?php
namespace Ateliee\PlantUMLParser;

/**
 * @property PUMLElement[] $value
 */
class PUMLElementList extends PUMLElement implements \ArrayAccess {

    /**
     * PUMLElementList constructor.
     */
    public function __construct()
    {
        parent::__construct([]);
    }

    /**
     * @param PUMLElement $elm
     */
    public function add($elm){
        $this->value[] = $elm;
    }

    public function __toString()
    {
        $str = $this->getOutputComment();
        foreach($this->value as $v){
            $v->setSetting($this->setting);
            $str .= (string)$v.PHP_EOL;
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
