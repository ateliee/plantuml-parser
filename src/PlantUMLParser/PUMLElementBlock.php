<?php
namespace Ateliee\PlantUMLParser;

/**
 * @property string $value
 */
class PUMLElementBlock extends PUMLElement implements \ArrayAccess
{

    /**
     * @var PUMLElementList $childs
     */
    protected $childs;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        parent::__construct($value);

        $this->childs = new PUMLElementList();
    }

    /**
     * @param PUMLElement $elm
     * @return $this
     */
    public function add($elm)
    {
        $this->childs->add($elm);
        return $this;
    }

    /**
     * @return string
     */
    public function getValueLabel()
    {
        return $this->value;
    }

    /**
     * @param string $current_indent
     * @param int $indent
     * @return string
     */
    public function str($current_indent, $indent)
    {
        $str = $this->getOutputComment($current_indent);
        $str .= $current_indent.sprintf('%s{', $this->getValueLabel()).PHP_EOL;
        $str .= $this->childs->str($current_indent.$this->makeIndent($indent), $indent);
        $str .= $current_indent.'}';
        if (!$current_indent) {
            $str .= PHP_EOL;
        }
        return $str;
    }


    public function offsetExists($offset)
    {
        return isset($this->childs[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->childs[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->childs[] = $value;
        } else {
            $this->childs[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->childs[$offset]);
    }
}
