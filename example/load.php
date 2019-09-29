<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Ateliee\PlantUMLParser\PUMLParser;


$plant_uml = new PUMLParser();
$uml = $plant_uml->load(__DIR__.'/test.puml');
$plant_uml->save(__DIR__.'/test.puml', $uml);