<?php
namespace Ateliee\PlantUMLParser;
use Ateliee\PlantUMLParser\Exception\InvalidParamaterException;
use Ateliee\PlantUMLParser\Exception\PUMLException;

/**
 * @property PUMLElement[] $value
 */
class PUMLElementList extends PUMLElement implements \ArrayAccess, \Countable {

    /**
     * PUMLElementList constructor.
     */
    public function __construct()
    {
        parent::__construct([]);
    }

    /**
     * 要素の追加
     *
     * @param PUMLElement|PUMLElement[] $elm
     * @throws PUMLException
     * @return $this
     */
    public function add($elm){

        $elm = func_get_args();
        if(count($elm) == 1){
            $elm = current($elm);
        }
        if(is_array($elm)){
            foreach($elm as $e){
                $this->add($e);
            }
            return $this;
        }
        if(!($elm instanceof PUMLElement)){
            throw new InvalidParamaterException();
        }
        $this->value[] = $elm;
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
        foreach($this->value as $v){
            $str .= $v->str($current_indent, $indent).PHP_EOL;
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

    public function count()
    {
        return count($this->value);
    }

    public function __toString()
    {
        return $this->str('', 2);
    }
}
