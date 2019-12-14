#!/usr/bin/env php
<?php
// ↓名前空間を利用するプロジェクトでは記述しておく
namespace busyoumono99\MyPackage;

// Composerのオートローダーを読み込む
require_once __DIR__ . '/vendor/autoload.php';
// ほかに初期化用のPHPファイルがあれば読み込んでおく
// require_once …

// .envの読込。.envが必要ない、使用しない場合はコメントアウトする
$dotenv = new \Dotenv\Dotenv(__DIR__.'/');
$dotenv->load();

echo __NAMESPACE__ . " shell\n";

$sh = new \Psy\Shell();

// シェル起動直後にプロジェクトのnamespaceを設定する
// 名前空間を利用しないプロジェクトでは↓の行は不要
$sh->addCode(sprintf("namespace %s;", __NAMESPACE__));

$sh->run();

// 終了時に表示するメッセージ
echo "Bye.\n";
