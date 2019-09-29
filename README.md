# PlantUML parser for PHP

[![Build Status](https://travis-ci.org/ateliee/plantuml-parser.svg?branch=development)](https://travis-ci.org/ateliee/plantuml-parser)
[![Coverage Status](https://coveralls.io/repos/github/ateliee/plantuml-parser/badge.svg?branch=development)](https://coveralls.io/github/ateliee/plantuml-parser?branch=development)

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
use Ateliee\PlantUMLParser\PUMLParser;
use Ateliee\PlantUMLParser\PUMLKeyValue;
use Ateliee\PlantUMLParser\PUMLStr;
use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\Structure\PUMLSkinParam;
use Ateliee\PlantUMLParser\Structure\PUMLDefine;
use Ateliee\PlantUMLParser\Structure\PUMLPackage;
use Ateliee\PlantUMLParser\Structure\PUMLEntity;
use Ateliee\PlantUMLParser\Structure\PUMLRelation;
use Ateliee\PlantUMLParser\Structure\PUMLNote;

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
            (new PUMLEntity('Customer'))
                ->add(new PUMLStr('+ ID [PK]'))
                ->add(new PUMLStr('--'))
                ->add(new PUMLStr('name'))
                ->add(new PUMLStr('zip'))
                ->add(new PUMLStr('address'))
                ->add(new PUMLStr('tel'))
                ->add(new PUMLStr('fax'))
        )
);
$plant_uml = new PUMLParser();
$plant_uml->save(__DIR__.'/test.puml', $uml);
```

## 参考
* [Plant UML](http://plantuml.com/ja/)
* [Real World PlantUML](https://real-world-plantuml.com/)