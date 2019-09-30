<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Ateliee\PlantUMLParser\PUMLParser;


$parser = new PUMLParser();
$uml = $parser->loadFile(__DIR__.'/test.puml');
$parser->save(__DIR__.'/test.puml', $uml);
//
//
//$uml = "@startuml
//Alice -> Bob: Authentication Request
//Bob --> Alice: Authentication Response
//
//Alice -> Bob: Another authentication Request
//Alice <-- Bob: another authentication Response
//@enduml";
//$parser = new PUMLParser();
//
//$result = $parser->parse($uml);
//
//var_dump($parser->output($result));