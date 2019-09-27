<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLElementBlock;

class PUMLSkinParam extends PUMLElementBlock {

    /**
     * PUMLSkinParam constructor.
     */
    public function __construct($value)
    {
        parent::__construct('skinparam', $value);
    }
}
