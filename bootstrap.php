<?php

error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

$appCfg = parse_ini_file("cfg/app.ini");

$loader = require 'vendor/autoload.php';
$loader->add($appCfg["app-name"], __DIR__.'/app/src');
$loader->add('App', __DIR__.'/lib/');