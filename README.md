# PlantUML parser for PHP

[PlantUML](http://plantuml.com/ja/)の書き込み・読み込みができるものがなかったので作成中。

## usage
* PHP 5.5.38 >=

## 機能
PlantUMLは機能が多いので、読み取り・出力はサポートしたい。

論理式は今の所対応しない予定

## 対応範囲

* [ ] Use Case (ユースケース図)
* [ ] Activity (アクティビティ図)
* [ ] State (ステートチャート図)	
* [ ] Sequence (シーケンス図)
* [ ] Class(クラス図)
* [ ] Object	(オブジェクト図)
* [ ] Component	(コンポーネント図)
* [ ] Component	(パッケージ図)
* [ ] Component	(配置図)

## 

```
$plant_uml = new PUMLParser();

$plant_uml->getRoot()->add((new PUMLDefine('MAIN_ENTITY', '#FCE4D6-F8CBAD'))->setComment("commnt to here"));

$plant_uml->getRoot()->add(
    (new PUMLSkinParam('class'))
        ->setComment("default style.")
        ->add(new PUMLKeyValue('BackgroundColor', 'METAL'))
        ->add(new PUMLKeyValue('BorderColor', 'Black'))
        ->add(new PUMLKeyValue('ArrowColor', 'Black'))
);

$plant_uml->getRoot()->add(
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
```

## 参考
* [Plant UML](http://plantuml.com/ja/)
* [Real World PlantUML](https://real-world-plantuml.com/)