<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Ateliee\PlantUMLParser;
use Ateliee\PlantUMLParser\Structure;

$plant_uml = new PlantUMLParser\PUMLParser();

$plant_uml->getRoot()->add((new Structure\PUMLDefine('MAIN_ENTITY', '#E2EFDA-C6E0B4'))->setComment("図の中で目立たせたいエンティティに着色するための
色の名前（定数）を定義します。"));
$plant_uml->getRoot()->add((new Structure\PUMLDefine('MAIN_ENTITY_2', '#FCE4D6-F8CBAD')));

$plant_uml->getRoot()->add((new Structure\PUMLDefine('METAL', '#F2F2F2-D9D9D9'))->setComment("他の色も、用途が分りやすいように名前をつけます。"));
$plant_uml->getRoot()->add((new Structure\PUMLDefine('MASTER_MARK_COLOR', '#AAFFAA')));
$plant_uml->getRoot()->add((new Structure\PUMLDefine('TRANSACTION_MARK_COLOR', '#FFAA00')));

$plant_uml->getRoot()->add(
    (new Structure\PUMLSkinParam('class'))
        ->setComment("デフォルトのスタイルを設定します。
この場合の指定は class です。entity ではエラーになります。")
        ->add(new PlantUMLParser\PUMLKeyValue('BackgroundColor', 'METAL'))
        ->add(new PlantUMLParser\PUMLKeyValue('BorderColor', 'Black'))
        ->add(new PlantUMLParser\PUMLKeyValue('ArrowColor', 'Black'))
);

$plant_uml->getRoot()->add(
    (new Structure\PUMLPackage('外部データベース', 'ext', '<<Database>>'))
        ->add(
            (new Structure\PUMLEntity('顧客マスタ', 'customer'))
        )
);
var_dump($plant_uml->output());