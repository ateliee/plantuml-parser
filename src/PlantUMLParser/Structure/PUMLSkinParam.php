<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLObject;

class PUMLSkinParam extends PUMLObject {

    /**
     * PUMLSkinParam constructor.
     */
    public function __construct($value)
    {
        parent::__construct('skinparam', $value);
    }
}
