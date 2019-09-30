<?php
namespace Ateliee\Tests;
use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\PUMLParser;

class PUMLAssert extends \PHPUnit_Framework_TestCase
{
//    public static function assertJsonColumns(array $expectedColumns, $json)
//    {
//        // 配列にdecodeして、キーが一致するか確認する
//        $data = json_decode($json, true);
//        self::assertTrue(is_array($data));
//        $keys = array_keys($data);
//        sort($keys); // json hash は本質的にカラム順の保証がないので、ソートしたうえでキーの一致チェックをしないとダメ
//        sort($expectedColumns);
//        self::assertEquals($expectedColumns, $keys);
//    }

    /**
     * UML文法のエンコード・デコード
     *
     * @param string $uml
     */
    public static function assertEncodeDecode($uml){

        $parser = new PUMLParser();

        $result = $parser->parse($uml);
        // 一致しているかどうか
        self::assertInstanceOf(
            PUMLElementList::class,
            $result
        );
        // 一致しているかどうか
        self::assertEquals(
            $uml,
            (string)$result
        );
    }
}