<?php
namespace Ateliee\Tests;

use Ateliee\PlantUMLParser\PUMLElement;
use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\PUMLParser;

class PUMLParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParamaters()
    {
        $parser = new PUMLParser();
        $uml = new PUMLElementList();

        $this->assertContainsOnly('string', [$parser->output($uml)]);
    }
}
