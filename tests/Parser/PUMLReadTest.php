<?php
namespace Ateliee\Tests\Parser;

use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\PUMLParser;
use Ateliee\Tests\PUMLAssert;

class PUMLReadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * シーケンス図の正常系テスト
     *
     * @see http://plantuml.com/ja/sequence-diagram
     */
    public function testParseSequence()
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
     * ファイル読み込み正常系
     */
    public function testLoadfile()
    {
        $parser = new PUMLParser();
        $uml = $parser->loadFile(__DIR__.'/../sample/test1.puml');
        $this->assertInstanceOf(PUMLElementList::class, $uml);

        $parser->save(__DIR__.'/../sample/test4.puml', $uml);

        $uml = $parser->loadFile(__DIR__.'/../sample/test2.puml');
        $this->assertInstanceOf(PUMLElementList::class, $uml);

        $uml = $parser->loadFile(__DIR__.'/../sample/test3.puml');
        $this->assertInstanceOf(PUMLElementList::class, $uml);
    }

    /**
     * エンコード正常系
     */
    public function testEncode()
    {
        $parser = new PUMLParser();
        $uml = $parser->loadString("@startuml
Alice -> Bob: Authentication Request
Bob --> Alice: Authentication Response
Alice -> Bob: Another authentication Request
Alice <-- Bob: another authentication Response

@enduml");
        $this->assertInternalType('string', $parser->encodep($parser->output($uml)));
    }

    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\FileOpenException
     */
    public function testFileOpenException()
    {

        $parser = new PUMLParser();
        $parser->loadFile(null);
    }

    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\FileOpenException
     */
    public function testFileOpenException2()
    {

        $parser = new PUMLParser();
        $parser->loadFile(__DIR__.'/a');
    }

    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\InvalidParamaterException
     */
    public function testInvalidParamaterException()
    {

        $parser = new PUMLParser();
        $parser->loadString(null);
    }


    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\SyntaxException
     */
    public function testSyntaxException()
    {

        $parser = new PUMLParser();
        $parser->loadString("@startuml
aasd");
        $parser->loadString("@startuml
        @startuml
aasd");
    }
    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\SyntaxException
     */
    public function testSyntaxException2()
    {

        $parser = new PUMLParser();
        $parser->loadString("@startuml
aasd");
    }
    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\SyntaxException
     */
    public function testSyntaxException3()
    {

        $parser = new PUMLParser();
        $parser->loadString("@enduml");
    }
    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\SyntaxException
     */
    public function testSyntaxException4()
    {

        $parser = new PUMLParser();
        $parser->loadString("@enduml
        aaaaa");
    }
}
