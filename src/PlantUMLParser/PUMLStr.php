<?php
namespace Ateliee\PlantUMLParser;

class PUMLStr extends PUMLElement {

    public function str($current_indent, $indent)
    {
        return $this->getOutputComment($current_indent).$current_indent.$this->value;
    }
}
