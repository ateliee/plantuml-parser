<?php
namespace Ateliee\Tests;

use Ateliee\PlantUMLParser\Exception\InvalidParamaterException;
use Ateliee\PlantUMLParser\PUMLElement;
use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\PUMLParser;
use Ateliee\PlantUMLParser\PUMLStr;

class PUMLElementTest extends \PHPUnit_Framework_TestCase {

    public function testList()
    {
        $uml = new PUMLElementList();

        $uml->add(new PUMLStr('SAMPLE'));
        $this->assertEquals(count($uml), 1);

        $uml->add(new PUMLStr('SAMPLE2'));
        $this->assertEquals(isset($uml[1]), true);
        $this->assertEquals(isset($uml[3]), false);
        $this->assertEquals(((string)$uml[1]), 'SAMPLE2');

        $uml[] = new PUMLStr('SAMPLE3');
        $this->assertEquals(isset($uml[2]), true);
        $this->assertEquals(((string)$uml[2]), 'SAMPLE3');

        // check name
        $this->assertEquals($uml::name(), 'ElementList');
        $this->assertEquals(PUMLStr::name(), 'Str');
//        $this->assertexce('string', [$parser->output($uml)]);
    }

    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\InvalidParamaterException
     */
    public function testInvalidParamaterException(){
        $uml = new PUMLElementList();
        $uml->add('test');
    }
}