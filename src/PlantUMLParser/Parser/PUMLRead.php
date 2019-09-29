<?php
namespace Ateliee\PlantUMLParser\Parser;

abstract class PUMLRead {
    /**
     * start
     *
     * @return bool
     */
    public abstract function open();
    /**
     * get next line
     *
     * @return string|false
     */
    public abstract function next();
    /**
     * end
     */
    public abstract function close();

    /**
     * @return int
     */
    public abstract function getLine();
}