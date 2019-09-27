<?php
namespace Ateliee\PlantUMLParser;

class PUMLElement {

    /**
     * @var string $value
     */
    protected $value;

    /**
     * @var string $comment
     */
    protected $comment;

    /**
     * @var PUMLSetting $setting
     */
    protected $setting;

    /**
     * @param string|PUMLElement $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getOutputComment()
    {
        if($this->comment){
            $list = explode(PHP_EOL, $this->comment);
            $before = '/\'';
            $after = '\'/';
            if(count($list) > 1){
                $before = $this->setting->getIndentString().$before.PHP_EOL;
                $after = PHP_EOL.$this->setting->getIndentString().$after;
                $list = array_map(function($str){
                    return $this->setting->getIndentString().'  '.$str;
                }, $list);
            }else{
                $before = $this->setting->getIndentString().$before.' ';
                $after = ' '.$after;
            }
            return PHP_EOL.$before.implode(PHP_EOL, $list).$after.PHP_EOL;
        }
        return "";
    }

    /**
     * @param PUMLSetting $setting
     * @return $this
     */
    public function setSetting($setting)
    {
        $this->setting = $setting;
        return $this;
    }

    /**
     * @return PUMLSetting
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * @return string|PUMLElement
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->getOutputComment().$this->setting->getIndentString().$this->value;
    }
}
