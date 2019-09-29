<?php
namespace Ateliee\Tests;

use Ateliee\PlantUMLParser\PUMLElement;
use Ateliee\PlantUMLParser\PUMLParser;

class PUMLParserTest extends \PHPUnit_Framework_TestCase {

    public function testParamaters()
    {
        $parser = new PUMLParser();

        $this->assertInstanceOf(PUMLElement::class, $parser->getRoot());
    }
}