<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLElementBlock;

class PUMLPackage extends PUMLElementBlock {

    public function __construct($value, $alias = null, $attributes = null)
    {
        parent::__construct('package', $value, $alias, $attributes);
    }
}
