<?php
namespace Ateliee\PlantUMLParser;

/**
 * Class PUMLSetting
 */
class PUMLSetting{

    /**
     * @var int $indent_count
     */
    protected $indent_count = 2;

    /**
     * @var int $count
     */
    protected $count = 0;

    /**
     * @var string $indent
     */
    protected $indent = ' ';

    /**
     * PUMLParser constructor.
     * @param int $indent_count
     * @param string $indent
     */
    public function __construct($indent_count = 2, $indent = ' ')
    {
        $this->indent_count = $indent_count;
        $this->indent = $indent;
        $this->count = 0;
    }

    /**
     * インデント追加
     */
    public function incriment(){
        $this->count ++;
    }

    /**
     * インデント削除
     */
    public function decriment(){
        $this->count = max($this->count - 1, 0);
    }

    public function __toString()
    {
        return $this->getIndentString();
    }

    /**
     * @return string
     */
    public function getIndentString(){
        return str_repeat($this->indent, $this->indent_count * $this->count);
    }
}
