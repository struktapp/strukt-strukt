<?php

require "bootstrap.php";

// Strukt\Rest\Request::shortenUrl(false);
Strukt\Rest\Router::useStaticDir(__DIR__."/public/static");

$r = \Strukt\Framework\Registry::getInstance();
$r->set("_dir", __DIR__);

App\Loader::getApp()->run();
// App\Loader::getApp()->runDebug();
