<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLObject;

class PUMLPackage extends PUMLObject {

    public function __construct($value, $alias = null, $attributes = null)
    {
        parent::__construct('package', $value, $alias, $attributes);
    }
}
