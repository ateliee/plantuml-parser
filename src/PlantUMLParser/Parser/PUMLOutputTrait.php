<?php
namespace Ateliee\PlantUMLParser\Parser;

use Ateliee\PlantUMLParser\Exception\FileOpenException;

trait PUMLOutputTrait
{
    /**
     * @param PUMLElement $element
     * @param int $indent
     * @return string
     */
    public function output($element, $indent = 2){
        $str = '@startuml'.PHP_EOL;
        $str .= $element->str('', $indent).PHP_EOL;
        $str .= '@enduml';
        return $str;
    }

    /**
     * @param string $file 保存するファイル名
     * @param int $indent インデント数
     * @throws FileOpenException
     */
    public function save($file, $element, $indent = 2) {
        if($fp = fopen($file, "w")){
            fwrite($fp, $this->output($element, $indent));
            fclose($fp);
        }else{
            throw new FileOpenException();
        }
    }

    /**
     * PlantUMLをパース
     *
     * @see http://plantuml.com/ja/code-php
     * @param string $text
     * @return mixed
     */
    public function encodep($text) {
        $data = utf8_encode($text);
        $compressed = gzdeflate($data, 9);
        return $this->encode64($compressed);
    }

    protected function encode6bit($b) {
        if ($b < 10) {
            return chr(48 + $b);
        }
        $b -= 10;
        if ($b < 26) {
            return chr(65 + $b);
        }
        $b -= 26;
        if ($b < 26) {
            return chr(97 + $b);
        }
        $b -= 26;
        if ($b == 0) {
            return '-';
        }
        if ($b == 1) {
            return '_';
        }
        return '?';
    }

    protected function append3bytes($b1, $b2, $b3) {
        $c1 = $b1 >> 2;
        $c2 = (($b1 & 0x3) << 4) | ($b2 >> 4);
        $c3 = (($b2 & 0xF) << 2) | ($b3 >> 6);
        $c4 = $b3 & 0x3F;
        $r = "";
        $r .= $this->encode6bit($c1 & 0x3F);
        $r .= $this->encode6bit($c2 & 0x3F);
        $r .= $this->encode6bit($c3 & 0x3F);
        $r .= $this->encode6bit($c4 & 0x3F);
        return $r;
    }

    protected function encode64($c) {
        $str = "";
        $len = strlen($c);
        for ($i = 0; $i < $len; $i+=3) {
            if ($i+2==$len) {
                $str .= $this->append3bytes(ord(substr($c, $i, 1)), ord(substr($c, $i+1, 1)), 0);
            } else if ($i+1==$len) {
                $str .= $this->append3bytes(ord(substr($c, $i, 1)), 0, 0);
            } else {
                $str .= $this->append3bytes(ord(substr($c, $i, 1)), ord(substr($c, $i+1, 1)),
                    ord(substr($c, $i+2, 1)));
            }
        }
        return $str;
    }
}