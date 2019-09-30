<?php
namespace Ateliee\Tests\Parser;

use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\PUMLParser;
use Ateliee\Tests\PUMLAssert;

class PUMLReadTest extends \PHPUnit_Framework_TestCase {

    /**
     * シーケンス図の正常系テスト
     *
     * @see http://plantuml.com/ja/sequence-diagram
     */
    public function testValidSequence()
    {
        PUMLAssert::assertEncodeDecode("@startuml
Alice -> Bob: Authentication Request
Bob --> Alice: Authentication Response
Alice -> Bob: Another authentication Request
Alice <-- Bob: another authentication Response

@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
actor Foo1
boundary Foo2
control Foo3
entity Foo4
database Foo5
collections Foo6
Foo1 -> Foo2 : To boundary
Foo1 -> Foo3 : To control
Foo1 -> Foo4 : To entity
Foo1 -> Foo5 : To database
Foo1 -> Foo6 : To collections

@enduml");
    }

    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\InvalidParamaterException
     */
    public function testInvalidParamaterException(){

        $parser = new PUMLParser();
        $parser->parse(null);
    }


    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\SyntaxException
     */
    public function testSyntaxException(){

        $parser = new PUMLParser();
        $parser->parse("@startuml
aasd");
        $parser->parse("@startuml
        @startuml
aasd");
    }
    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\SyntaxException
     */
    public function testSyntaxException2(){

        $parser = new PUMLParser();
        $parser->parse("@startuml
aasd");
    }
    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\SyntaxException
     */
    public function testSyntaxException3(){

        $parser = new PUMLParser();
        $parser->parse("@enduml");
    }
    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\SyntaxException
     */
    public function testSyntaxException4(){

        $parser = new PUMLParser();
        $parser->parse("@enduml
        aaaaa");
    }
}