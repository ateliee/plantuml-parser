<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Ateliee\PlantUMLParser\PUMLParser;
use Ateliee\PlantUMLParser\PUMLKeyValue;
use Ateliee\PlantUMLParser\PUMLStr;
use Ateliee\PlantUMLParser\Structure\PUMLSkinParam;
use Ateliee\PlantUMLParser\Structure\PUMLDefine;
use Ateliee\PlantUMLParser\Structure\PUMLPackage;
use Ateliee\PlantUMLParser\Structure\PUMLEntity;

/**
 * @see https://qiita.com/Tachy_Pochy/items/752ef6e3d38e970378f0
 */
$plant_uml = new PUMLParser();

$plant_uml->getRoot()->add((new PUMLDefine('MAIN_ENTITY', '#E2EFDA-C6E0B4'))->setComment("図の中で目立たせたいエンティティに着色するための
色の名前（定数）を定義します。"));
$plant_uml->getRoot()->add((new PUMLDefine('MAIN_ENTITY_2', '#FCE4D6-F8CBAD')));

$plant_uml->getRoot()->add((new PUMLDefine('METAL', '#F2F2F2-D9D9D9'))->setComment("他の色も、用途が分りやすいように名前をつけます。"));
$plant_uml->getRoot()->add((new PUMLDefine('MASTER_MARK_COLOR', '#AAFFAA')));
$plant_uml->getRoot()->add((new PUMLDefine('TRANSACTION_MARK_COLOR', '#FFAA00')));

$plant_uml->getRoot()->add(
    (new PUMLSkinParam('class'))
        ->setComment("デフォルトのスタイルを設定します。
この場合の指定は class です。entity ではエラーになります。")
        ->add(new PUMLKeyValue('BackgroundColor', 'METAL'))
        ->add(new PUMLKeyValue('BorderColor', 'Black'))
        ->add(new PUMLKeyValue('ArrowColor', 'Black'))
);

$plant_uml->getRoot()->add(
    (new PUMLPackage('外部データベース', 'ext', '<<Database>>'))
        ->add(
            (new PUMLEntity('顧客マスタ', 'customer'))
                ->add(new PUMLStr('+ 顧客ID [PK]'))
                ->add(new PUMLStr('--'))
                ->add(new PUMLStr('顧客名'))
                ->add(new PUMLStr('郵便番号'))
                ->add(new PUMLStr('住所'))
                ->add(new PUMLStr('電話番号'))
                ->add(new PUMLStr('FAX'))
        )
);

$plant_uml->save(__DIR__.'/test.puml');
var_dump($plant_uml->output());