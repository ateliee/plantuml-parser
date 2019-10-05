<?php
namespace Ateliee\PlantUMLParser\Parser;

use Ateliee\PlantUMLParser\Exception\InvalidParamaterException;

class PUMLReadString extends PUMLRead
{

    /**
     * @var string[]
     */
    protected $lines;

    /**
     * @var int
     */
    protected $number;

    public function __construct($str)
    {
        if (!is_string($str)) {
            throw new InvalidParamaterException();
        }
        $this->lines = explode(PHP_EOL, $str);
        $this->number = 0;
    }

    /**
     * start
     * @return bool
     */
    public function open()
    {
        $this->number = 0;
        return true;
    }

    /**
     * get next line
     *
     * @return string|false
     */
    public function next()
    {
        if (count($this->lines) <= $this->number) {
            return false;
        }
        return trim($this->lines[$this->number++]);
    }

    /**
     * end
     */
    public function close()
    {
    }

    /**
     * @return int
     */
    public function getLine()
    {
        return $this->number;
    }
}
