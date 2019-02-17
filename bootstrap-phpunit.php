<?php

use Strukt\Fs;
use Strukt\Event\Event;
use Strukt\Core\Registry;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

ini_set('display_errors', '1');
ini_set("date.timezone", "Africa/Nairobi");

error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

$appCfg = parse_ini_file("cfg/app.ini");

$loader = require 'vendor/autoload.php';
$loader->add('App', __DIR__.'/lib/');
$loader->add($appCfg["app-name"], __DIR__.'/app/src/');

/*setup http messenger*/
$request = Request::createFromGlobals();

$request = new Request(
    $_GET,
    $_POST,
    array(),
    $_COOKIE,
    $_FILES,
    $_SERVER
);

$registry = Registry::getInstance();
$registry->set("_dir", __DIR__);
$registry->set("_staticDir", __DIR__."/public/static");
$registry->set("appPath", "app/src/");
$registry->set("request", $request);//Request

foreach(["NotFound"=>404, 
			"MethodNotFound"=>405,
		 	"Forbidden"=>403, 
		 	"ServerError"=>500,
			"Ok"=>200, 
			"Redirected"=>302] as $msg=>$code)
	$registry->set(sprintf("Response.%s", $msg), new Event(function() use($code){

		$body = "";
        if(in_array($code, array(403,404,405,500)))
            $body = Fs::cat(sprintf("public/errors/%d.html", $code));

        $res = new Response(

            $body,
            $code,
            array('content-type' => 'text/html')
        );

        return $res;
	}));

$app = App\Loader::getApp();