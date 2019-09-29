<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLKeyValue;

class PUMLDefine extends PUMLKeyValue {

    /**
     * @param string $current_indent
     * @param int $indent
     * @return string
     */
    public function str($current_indent, $indent)
    {
        return $this->getOutputComment($current_indent).$current_indent.sprintf('!define %s %s', $this->key, $this->value);
    }
}
