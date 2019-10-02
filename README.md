# PlantUML parser for PHP

[![Build Status](https://travis-ci.org/ateliee/plantuml-parser.svg?branch=development)](https://travis-ci.org/ateliee/plantuml-parser)
[![Coverage Status](https://coveralls.io/repos/github/ateliee/plantuml-parser/badge.svg?branch=%28HEAD+detached+at+75dabae%29)](https://coveralls.io/github/ateliee/plantuml-parser?branch=%28HEAD+detached+at+75dabae%29)
[![Latest Stable Version](https://poser.pugx.org/ateliee/plantuml-parser/v/stable)](https://packagist.org/packages/ateliee/plantuml-parser)
[![Total Downloads](https://poser.pugx.org/ateliee/plantuml-parser/downloads)](https://packagist.org/packages/ateliee/plantuml-parser)

[PlantUML](http://plantuml.com/ja/)の書き込み・読み込みができるものがなかったので作成。

## usage
* PHP 5.5.38 >=

## 機能
PlantUMLは機能が多いので、読み取り・出力のみサポート。

論理式は今の所対応しない予定

## 対応範囲

* [ ] Use Case (ユースケース図)
* [ ] Activity (アクティビティ図)
* [ ] State (ステートチャート図)	
* [ ] Sequence (シーケンス図)
* [x] Class (クラス図)
* [x] Object (オブジェクト図)
* [ ] Component (コンポーネント図)
* [ ] Component (パッケージ図)
* [ ] Component (配置図)

## install
```
composer require ateliee/plantuml-parser
```

## example

```
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
```

```puml
@startuml

/' commnt to here '/
!define MAIN_ENTITY #FCE4D6-F8CBAD

/' default style. '/
skinparam class{
  BackgroundColor METAL
  BorderColor Black
  ArrowColor Black
}

package "DB" as ext <<Database>>{
  entity "Customer" as customer{
    + ID [PK]
    --
    name
    zip
    address
    tel
    fax
  }
}

package "開発対象システム" as target_system{

  /'
    マスターテーブルを M、トランザクションを T などと安直にしていますが、
    チーム内でルールを決めればなんでも良いと思います。交差テーブルは "I" とか。
    角丸四角形が描けない代替です。
    １文字なら "主" とか "従" とか日本語でも OK だったのが受ける。
  '/
  entity "注文テーブル" as order <<主,TRANSACTION_MARK_COLOR>> MAIN_ENTITY{
    + 注文ID [PK]
    --
    # 顧客ID [FK]
    注文日時
    配送希望日
    配送方法
    お届け先名
    お届け先住所
    決済方法
    合計金額
    消費税額
  }
}

customer |o-ri-o{ order

@enduml
```

## 参考
* [Plant UML](http://plantuml.com/ja/)
* [Real World PlantUML](https://real-world-plantuml.com/)