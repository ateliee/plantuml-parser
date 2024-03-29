<?php
namespace Ateliee\Tests;

use Ateliee\PlantUMLParser\Exception\InvalidParamaterException;
use Ateliee\PlantUMLParser\PUMLElement;
use Ateliee\PlantUMLParser\PUMLElementBlock;
use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\PUMLKeyValue;
use Ateliee\PlantUMLParser\PUMLObject;
use Ateliee\PlantUMLParser\PUMLParser;
use Ateliee\PlantUMLParser\PUMLStr;

class PUMLElementTest extends \PHPUnit_Framework_TestCase
{
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

        unset($uml[2]);
        $this->assertEquals(count($uml), 2);

        $uml[2] = new PUMLStr('SAMPLE4');
        $uml->add([
            new PUMLStr('SAMPLE5'),
            new PUMLStr('SAMPLE6')
        ]);

        $block = (new PUMLElementBlock('test'))
            ->setComment("default style.")
            ->add(new PUMLKeyValue('BackgroundColor', 'METAL'))
            ->add(new PUMLKeyValue('BackgroundColor2', 'BLACK'))
        ;

        $this->assertEquals(isset($block[0]), true);
        $this->assertContainsOnlyInstancesOf(PUMLKeyValue::class, [$block[0]]);
        $this->assertEquals(isset($block[1]), true);

        unset($block[0]);
        $this->assertEquals(isset($block[0]), false);
        $this->assertEquals(isset($block[2]), false);

        $block[] = new PUMLKeyValue('BackgroundColor', 'METAL');
        $this->assertEquals(isset($block[2]), true);

        $uml->add($block);
        $this->assertEquals(count($uml), 6);

        $this->assertContainsOnly('string', [(string)$uml]);

        // check name
        $this->assertEquals($uml::name(), 'ElementList');
        $this->assertEquals(PUMLStr::name(), 'Str');
//        $this->assertexce('string', [$parser->output($uml)]);
    }

    public function testElement()
    {
        $str = new PUMLStr('SAMPLE');
        $this->assertEquals('SAMPLE', $str->getValue());
        $this->assertEquals('', $str->getOutputComment());
        $this->assertEquals($str, $str->setComment('test'));
        $this->assertEquals('test', $str->getComment());

        $str->setComment('これはテスト');

        $this->assertEquals("/' これはテスト '/", trim($str->getOutputComment()));

        $str->setComment("複数行\nこれもテスト");
        $this->assertEquals("/'\n  複数行\n  これもテスト\n'/", trim($str->getOutputComment()));
    }

    public function testObject()
    {
        $str = new PUMLObject('entity', 'サンプル', 'Entity', '<T>');
        $result = 'entity "サンプル" as Entity <T>';
        $this->assertEquals($result, ($str->getValueLabel()));
    }

    public function testElementBlock()
    {
        $str = new PUMLElementBlock('entity');
        $result = 'entity';
        $this->assertEquals($result, ($str->getValueLabel()));
    }

    /**
     * @test
     * @expectedException Ateliee\PlantUMLParser\Exception\InvalidParamaterException
     */
    public function testInvalidParamaterException()
    {
        $uml = new PUMLElementList();
        $uml->add('test');
    }
}
