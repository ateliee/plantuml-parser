<?php
namespace Ateliee\PlantUMLParser;

class PUMLKeyValue extends PUMLElement
{

    /**
     * @var string $key
     */
    protected $key;

    /**
     * @param string $key
     * @param string $value
     */
    public function __construct($key, $value)
    {
        parent::__construct($value);

        $this->key = $key;
    }

    public function str($current_indent, $indent)
    {
        return $this->getOutputComment($current_indent).$current_indent.(string)$this;
    }

    public function __toString()
    {
        return sprintf('%s %s', $this->key, $this->value);
    }
}
