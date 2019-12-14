<?php
namespace Ateliee\PlantUMLParser;

abstract class PUMLElement
{

    /**
     * get PUML Element name
     *
     * @return string
     */
    public static function name()
    {
        $cname = explode('\\', get_called_class());
        $cname = end($cname);
        if (preg_match('/^PUML(.+)$/', $cname, $matchs)) {
            $cname = $matchs[1];
        }
        return $cname;
    }

    /**
     * @var string $value
     */
    protected $value;

    /**
     * @var string $comment
     */
    protected $comment;

    /**
     * @param string|PUMLElement|mixed $value
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
    public function getComment()
    {
        return $this->comment;
    }


    /**
     * コメントを出力
     *
     * @param  string $indent
     * @return string
     */
    public function getOutputComment($indent = '')
    {
        if ($this->comment) {
            $list = explode(PHP_EOL, $this->comment);
            $before = '/\'';
            $after = '\'/';
            if (count($list) > 1) {
                $before = $indent.$before.PHP_EOL;
                $after = PHP_EOL.$indent.$after;
                $list = array_map(function ($str) use ($indent) {
                    return $indent.'  '.$str;
                }, $list);
            } else {
                $before = $indent.$before.' ';
                $after = ' '.$after;
            }
            return PHP_EOL.$before.implode(PHP_EOL, $list).$after.PHP_EOL;
        }
        return "";
    }

    /**
     * @return string|PUMLElement
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * 文字列として出力
     *
     * @param string $current_indent
     * @param int $indent
     * @return mixed
     */
    abstract public function str($current_indent, $indent);

    /**
     * @param int $indent
     * @return string
     */
    protected function makeIndent($indent = 2)
    {
        return str_repeat(' ', $indent);
    }
}
