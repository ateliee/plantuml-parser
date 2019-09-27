<?php
namespace Ateliee\PlantUMLParser;

class PUMLKeyValue extends PUMLElement {

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

    public function __toString()
    {
        return $this->getOutputComment().sprintf('%s %s', $this->key, $this->value);
    }
}
