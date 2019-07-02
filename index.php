<?php

require "bootstrap.php";

use Strukt\Http\Response;
use Strukt\Http\Request;
use Strukt\Http\RedirectResponse;
use Strukt\Http\Session;

use Strukt\Router\Middleware\ExceptionHandler;
use Strukt\Router\Middleware\Authentication; 
use Strukt\Router\Middleware\Authorization;
use Strukt\Router\Middleware\StaticFileFinder;
use Strukt\Router\Middleware\Session as SessionMiddleware;
use Strukt\Router\Middleware\Router as RouterMiddleware;

use Strukt\Framework\Provider\Validator;
use Strukt\Framework\Provider\Annotation;
use Strukt\Framework\Provider\Router as RouterProvider;

use Strukt\Event\Event;
use Strukt\Env;

Env::set("root_dir", getcwd());
Env::set("rel_static_dir", "/public/static");
Env::set("rel_mod_ini", "/cfg/module.ini");
Env::set("is_dev", true);

$kernel = new Strukt\Router\Kernel(Request::createFromGlobals());
$kernel->inject("app.dep.author", function(){

	return array(

		"permissions" => array(

			// "show_secrets"
			// "user_all"
		)
	);
});
$kernel->inject("app.dep.authentic", function(Session $session){

	$user = new Strukt\User();
	$user->setUsername($session->get("username"));

	return $user;
});

$kernel->inject("app.dep.session", function(){

	return new Session;
});

$kernel->providers(array(

	Validator::class,
	Annotation::class,
	RouterProvider::class
));

$kernel->middlewares(array(
	
	ExceptionHandler::class,
	SessionMiddleware::class,
	Authorization::class,
	Authentication::class,
	StaticFileFinder::class,
	RouterMiddleware::class
));

$loader = new App\Loader($kernel);
$app = $loader->getApp(); 
$app->runDebug();