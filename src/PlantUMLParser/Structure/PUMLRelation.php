<?php
namespace Ateliee\PlantUMLParser\Structure;

use Ateliee\PlantUMLParser\PUMLElement;

/**
 * カーディナリティ
 * @see http://plantuml.com/ja/class-diagram#Hide
 */
class PUMLRelation extends PUMLElement {

    /**
     * @var string 対象先
     */
    protected $value2;

    /**
     * @var string 関係図
     */
    protected $related;

    /**
     * @var string|null
     */
    protected $attributes = null;

    public function __construct($value, $related, $value2, $attributes = null)
    {
        parent::__construct($value);

        $this->related = $related;
        $this->value2 = $value2;
        $this->attributes = $attributes;
    }

    public function str($current_indent, $indent)
    {
        return $this->getOutputComment($current_indent).
            $current_indent.
            sprintf('%s %s %s%s',
                $this->value,
                $this->related,
                $this->value2,
                $this->attributes ? ' '.$this->attributes : ''
            );
    }
}
