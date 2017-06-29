<?php

error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

$loader = require 'vendor/autoload.php';
$loader->add('Payroll', __DIR__.'/app/src');
$loader->add('App', __DIR__.'/lib/');