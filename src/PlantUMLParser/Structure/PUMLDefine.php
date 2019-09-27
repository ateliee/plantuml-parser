<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLKeyValue;

class PUMLDefine extends PUMLKeyValue {

    public function __toString()
    {
        return $this->getOutputComment().$this->setting->getIndentString().sprintf('!define %s %s', $this->key, $this->value);
    }
}
