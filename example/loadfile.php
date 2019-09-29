<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Ateliee\PlantUMLParser\PUMLParser;
use Ateliee\PlantUMLParser\PUMLKeyValue;
use Ateliee\PlantUMLParser\PUMLStr;
use Ateliee\PlantUMLParser\Structure\PUMLSkinParam;
use Ateliee\PlantUMLParser\Structure\PUMLDefine;
use Ateliee\PlantUMLParser\Structure\PUMLPackage;
use Ateliee\PlantUMLParser\Structure\PUMLEntity;
use Ateliee\PlantUMLParser\Structure\PUMLRelation;
use Ateliee\PlantUMLParser\Structure\PUMLNote;

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


$plant_uml->getRoot()->add(
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
        ->add(
            (new PUMLEntity('注文明細テーブル', 'order_detail', '<<T,TRANSACTION_MARK_COLOR>> MAIN_ENTITY_2'))
                ->add(new PUMLStr('+ 注文ID [PK]'))
                ->add(new PUMLStr('+ 明細番号 [PK]'))
                ->add(new PUMLStr('--'))
                ->add(new PUMLStr('# SKU [FK]'))
                ->add(new PUMLStr('注文数'))
                ->add(new PUMLStr('税抜価格'))
                ->add(new PUMLStr('税込価格'))
        )
        ->add(
            (new PUMLEntity('SKUマスタ', 'sku', '<<M,MASTER_MARK_COLOR>>'))
                ->add(new PUMLStr('+ SKU [PK]'))
                ->add(new PUMLStr('--'))
                ->add(new PUMLStr('# 商品ID [FK]'))
                ->add(new PUMLStr('カラー'))
                ->add(new PUMLStr('サイズ'))
                ->add(new PUMLStr('重量'))
                ->add(new PUMLStr('販売単価'))
                ->add(new PUMLStr('仕入単価'))
        )
        ->add(
            (new PUMLEntity('商品マスタ', 'product', '<<M,MASTER_MARK_COLOR>>'))
                ->add(new PUMLStr('+ 商品ID [PK]'))
                ->add(new PUMLStr('--'))
                ->add(new PUMLStr('商品名'))
                ->add(new PUMLStr('原産国'))
                ->add(new PUMLStr('# 仕入先ID [FK]'))
                ->add(new PUMLStr('商品カテゴリ'))
                ->add(new PUMLStr('配送必要日数'))
        )
        ->add(
            (new PUMLEntity('仕入先マスタ', 'vendor', '<<M,MASTER_MARK_COLOR>>'))
                ->add(new PUMLStr('+ 仕入先ID [PK]'))
                ->add(new PUMLStr('--'))
                ->add(new PUMLStr('仕入れ先名'))
                ->add(new PUMLStr('郵便番号'))
                ->add(new PUMLStr('住所'))
                ->add(new PUMLStr('電話番号'))
                ->add(new PUMLStr('FAX番号'))
        )
);


$plant_uml->getRoot()->add(
    (new PUMLRelation('customer', '|o-ri-o{', 'order')),
    (new PUMLRelation('order', '||-ri-|{', 'order_detail')),
    (new PUMLRelation('order_detail', '}-do-||', 'sku')),
    (new PUMLRelation('sku', '}-le-||', 'product')),
    (new PUMLRelation('product', '}o-le-||', 'vendor'))
);

$plant_uml->getRoot()->add(
    (new PUMLNote('bottom of customer : 別プロジェクト\nDB-Linkで参照する'))
);

$plant_uml->save(__DIR__.'/test.puml');
var_dump($plant_uml->output());