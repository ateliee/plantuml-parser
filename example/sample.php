<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Ateliee\PlantUMLParser\PUMLParser;
use Ateliee\PlantUMLParser\PUMLKeyValue;
use Ateliee\PlantUMLParser\PUMLStr;
use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\Structure\PUMLSkinParam;
use Ateliee\PlantUMLParser\Structure\PUMLDefine;
use Ateliee\PlantUMLParser\Structure\PUMLPackage;
use Ateliee\PlantUMLParser\Structure\PUMLEntity;
use Ateliee\PlantUMLParser\Structure\PUMLRelation;

$uml = new PUMLElementList();

$uml->add((new PUMLDefine('MAIN_ENTITY', '#FCE4D6-F8CBAD'))->setComment("commnt to here"));

$uml->add(
    (new PUMLSkinParam('class'))
        ->setComment("default style.")
        ->add(new PUMLKeyValue('BackgroundColor', 'METAL'))
        ->add(new PUMLKeyValue('BorderColor', 'Black'))
        ->add(new PUMLKeyValue('ArrowColor', 'Black'))
);

$uml->add(
    (new PUMLPackage('DB', 'ext', '<<Database>>'))
        ->add(
            (new PUMLEntity('Customer', 'customer'))
                ->add(new PUMLStr('+ ID [PK]'))
                ->add(new PUMLStr('--'))
                ->add(new PUMLStr('name'))
                ->add(new PUMLStr('zip'))
                ->add(new PUMLStr('address'))
                ->add(new PUMLStr('tel'))
                ->add(new PUMLStr('fax'))
        )
);
$uml->add(
    (new PUMLPackage('開発対象システム', 'target_system'))
        ->add(
            (new PUMLEntity('注文テーブル', 'order', '<<主,TRANSACTION_MARK_COLOR>> MAIN_ENTITY'))
                ->add(new PUMLStr('+ 注文ID [PK]'))
                ->add(new PUMLStr('--'))
                ->add(new PUMLStr('# 顧客ID [FK]'))
                ->add(new PUMLStr('注文日時'))
                ->add(new PUMLStr('配送希望日'))
                ->add(new PUMLStr('配送方法'))
                ->add(new PUMLStr('お届け先名'))
                ->add(new PUMLStr('お届け先住所'))
                ->add(new PUMLStr('決済方法'))
                ->add(new PUMLStr('合計金額'))
                ->add(new PUMLStr('消費税額'))
                ->setComment("マスターテーブルを M、トランザクションを T などと安直にしていますが、
チーム内でルールを決めればなんでも良いと思います。交差テーブルは \"I\" とか。
角丸四角形が描けない代替です。
１文字なら \"主\" とか \"従\" とか日本語でも OK だったのが受ける。")
        )
);

$uml->add(
    (new PUMLRelation('customer', '|o-ri-o{', 'order'))
);

$plant_uml = new PUMLParser();
$plant_uml->save(__DIR__.'/test.puml', $uml);