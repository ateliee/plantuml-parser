<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Ateliee\PlantUMLParser\PUMLParser;

$parser = new PUMLParser();
$uml = $parser->loadFile(__DIR__.'/test.puml');
$parser->save(__DIR__.'/test.puml', $uml);
