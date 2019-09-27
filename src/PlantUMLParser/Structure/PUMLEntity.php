<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLElementBlock;

class PUMLEntity extends PUMLElementBlock {

    public function __construct($value, $alias = null, $attributes = null)
    {
        parent::__construct('entity', $value, $alias, $attributes);
    }
}
