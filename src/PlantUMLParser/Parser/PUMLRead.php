<?php
namespace Ateliee\PlantUMLParser\Parser;

abstract class PUMLRead
{
    /**
     * start
     *
     * @return bool
     */
    abstract public function open();
    /**
     * get next line
     *
     * @return string|false
     */
    abstract public function next();
    /**
     * end
     */
    abstract public function close();

    /**
     * @return int
     */
    abstract public function getLine();
}
