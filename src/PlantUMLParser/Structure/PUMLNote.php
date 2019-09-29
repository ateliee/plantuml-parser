<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLElement;

/**
 * カーディナリティ
 */
class PUMLNote extends PUMLElement {

    public function str($current_indent, $indent)
    {
        return $this->getOutputComment($current_indent). $current_indent. sprintf('note %s', $this->value);
    }
}
