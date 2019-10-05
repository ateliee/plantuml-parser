<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLObject;

class PUMLEntity extends PUMLObject
{

    public function __construct($value, $alias = null, $attributes = null)
    {
        parent::__construct('entity', $value, $alias, $attributes);
    }
}
