<?php
namespace Ateliee\PlantUMLParser\Parser;

use Ateliee\PlantUMLParser\Exception\FileOpenException;
use Ateliee\PlantUMLParser\Exception\InvalidParamaterException;
use Ateliee\PlantUMLParser\Exception\PUMLException;
use Ateliee\PlantUMLParser\Exception\SyntaxException;
use Ateliee\PlantUMLParser\PUMLElement;
use Ateliee\PlantUMLParser\PUMLElementBlock;
use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\PUMLStr;
use Ateliee\PlantUMLParser\Structure\PUMLDefine;
use Ateliee\PlantUMLParser\Structure\PUMLEntity;
use Ateliee\PlantUMLParser\Structure\PUMLNote;
use Ateliee\PlantUMLParser\Structure\PUMLPackage;
use Ateliee\PlantUMLParser\Structure\PUMLSkinParam;

class PUMLParse
{
    const PARSESTATUS_EMPTY = 0;
    const PARSESTATUS_START = 1;
    const PARSESTATUS_FINISH = 100;

    /**
     * @var int
     */
    protected $parseStatus;

    /**
     * Read String
     *
     * @param string $str
     * @return PUMLElementList
     */
    public function loadString($str)
    {
        return $this->parserExecute(new PUMLReadString($str));
    }

    /**
     * Read File
     *
     * @param string $file
     * @return PUMLElementList
     */
    public function loadFile($file)
    {
        return $this->parserExecute(new PUMLReadFile($file));
    }

    /**
     * @param PUMLRead $reader
     * @return PUMLElementList
     *
     * @throws FileOpenException
     * @throws PUMLException
     * @throws SyntaxException
     */
    protected function parserExecute($reader)
    {
        if ($reader->open()) {
            try {
                $this->parseStatus = self::PARSESTATUS_EMPTY;
                $root = $element = new PUMLElementList();
                while (($item = $reader->next()) !== false) {
                    $element = $this->parseLine($reader, $element, $item);
                }
            } catch (SyntaxException $e) {
                throw $e;
            } catch (PUMLException $e) {
                throw $e;
            } finally {
                $reader->close();
                $this->tmpElement = null;
            }
            if ($this->parseStatus != self::PARSESTATUS_FINISH) {
                throw new SyntaxException(sprintf('Not Found @enduml.'));
            }
        } else {
            throw new FileOpenException();
        }
        return $root;
    }

    /**
     * 1行ずつパースする
     *
     * @param PUMLRead $reader
     * @param PUMLElementList $element
     * @param string $str
     * @param int $nest
     * @return PUMLElement
     * @throws SyntaxException
     * @throws PUMLException
     */
    protected function parseLine($reader, $element, $str, $nest = 0)
    {
        if ($str == '@startuml') {
            if ($this->parseStatus != self::PARSESTATUS_EMPTY) {
                $message = sprintf('Not Found @startuml. "%s" line %d', $str, $reader->getLine());
                throw new SyntaxException($message);
            }
            $this->parseStatus = self::PARSESTATUS_START;
        } elseif ($str == '@enduml') {
            if ($this->parseStatus != self::PARSESTATUS_START) {
                $message = sprintf('Not Found @startuml. "%s" line %d', $str, $reader->getLine());
                throw new SyntaxException($message);
            }
            if ($nest != 0) {
                $message = sprintf('Not Found end Block. "%s" line %d', $str, $reader->getLine());
                throw new SyntaxException($message);
            }
            $this->parseStatus = self::PARSESTATUS_FINISH;
        } elseif ($str != '') {
            if ($this->parseStatus == self::PARSESTATUS_FINISH) {
                $message = sprintf('@enduml After String Not Support. "%s" line %d', $str, $reader->getLine());
                throw new SyntaxException($message);
            }
            // comment
            $comment = null;
            if (preg_match('/^\/\'(.*)$/', $str, $matchs)) {
                if (preg_match('/^(.*)\'\/$/', $matchs[1], $mt)) {
                    $comment = $mt[1];
                    if (($str = $reader->next()) == false) {
                        return $element;
                    }
                } else {
                    $comment = $matchs[1];
                    $end_block = false;
                    $n = 0;
                    while (($str = $reader->next()) !== false) {
                        if (preg_match('/^(.*)\'\/$/', $str, $matchs)) {
                            $comment .= $matchs[1];
                            $end_block = true;
                            break;
                        }
                        $comment .= ($n ? PHP_EOL : '').$str;
                        $n ++;
                    }
                    if (!$end_block) {
                        $message = sprintf(
                            'Invalid Comment Block End "\'" Not Found. "%s" line %d',
                            $str,
                            $reader->getLine()
                        );
                        throw new SyntaxException($message);
                    }
                    if (($str = $reader->next()) == false) {
                        return $element;
                    }
                }
            }
            // block
            if (preg_match('/^(.+){$/', $str, $matchs)) {
                $block = $this->makeBlock($matchs[1]);
                $end_block = false;
                while (($item = $reader->next()) !== false) {
                    if (preg_match('/^}$/', $item, $matchs)) {
                        $end_block = true;
                        break;
                    }
                    $block = $this->parseLine($reader, $block, $item, $nest + 1);
                }
                if (!$end_block) {
                    $message = sprintf(
                        'Invalid Block End "}" Not Found. "%s" line %d',
                        $item,
                        $reader->getLine()
                    );
                    throw new SyntaxException($message);
                }
            } else {
                $block = $this->makeElement($str);
            }
            if ($comment) {
                $block->setComment($comment);
            }
            $element->add($block);
        }
        return $element;
    }

    /**
     * @param string $str
     * @return PUMLElementBlock
     */
    protected function makeBlock($str)
    {
        if (preg_match('/^entity (.+)$/', $str, $matchs)) {
            return new PUMLEntity($matchs[1]);
        } elseif (preg_match('/^package (.+)$/', $str, $matchs)) {
            return new PUMLPackage($matchs[1]);
        } elseif (preg_match('/^skinparam (.+)$/', $str, $matchs)) {
            return new PUMLSkinParam($matchs[1]);
        }
        return new PUMLElementBlock($str);
    }

    /**
     * @param string $str
     * @return PUMLElement
     */
    protected function makeElement($str)
    {
        if (preg_match('/^!define (.+!) (.+)$/', $str, $matchs)) {
            return new PUMLDefine($matchs[1], $matchs[2]);
        } elseif (preg_match('/^note (.+)$/', $str, $matchs)) {
            return new PUMLNote($matchs[1]);
        }
        return new PUMLStr($str);
    }
}
