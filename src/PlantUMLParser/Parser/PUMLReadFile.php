<?php
namespace Ateliee\PlantUMLParser\Parser;

use Ateliee\PlantUMLParser\Exception\FileOpenException;
use Ateliee\PlantUMLParser\Exception\InvalidParamaterException;

class PUMLReadFile extends PUMLRead {

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var resource
     */
    protected $file;

    /**
     * @var int
     */
    protected $number;

    public function __construct($str)
    {
        if(!is_string($str)){
            throw new InvalidParamaterException();
        }
        $this->filename = $str;
        $this->file = null;
        $this->number = 0;
    }

    /**
     * start
     * @return bool
     * @throws FileOpenException
     */
    public function open(){
        if($this->file != null){
            throw new FileOpenException('Already open file.');
        }
        $this->file = fopen($this->filename, "r");
        $this->number = 0;
        return $this->file != null;
    }

    /**
     * get next line
     *
     * @return string|false
     */
    public function next(){
        $this->number ++;

        if(($str = fgets($this->file)) !== false){
            return trim($str);
        }
        return false;
    }

    /**
     * end
     */
    public function close(){
        fclose($this->file);
        $this->number = 0;
    }

    /**
     * @return int
     */
    public function getLine(){
        return $this->number;
    }
}