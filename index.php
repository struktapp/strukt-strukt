<?php

require "bootstrap.php";

use Strukt\Http\Response;
use Strukt\Http\Request;
use Strukt\Http\RedirectResponse;
use Strukt\Http\Session;

use Strukt\Router\Middleware\ExceptionHandler;
use Strukt\Router\Middleware\Session as SessionMiddleware;
use Strukt\Router\Middleware\Authentication; 
use Strukt\Router\Middleware\Authorization;
use Strukt\Router\Middleware\StaticFileFinder;
use Strukt\Router\Middleware\Router;

use Strukt\Event\Event;
use Strukt\Env;

Env::set("root_dir", getcwd());
Env::set("rel_static_dir", "public/static");
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
$kernel->inject("app.dep.authetic", function(Session $session){

	$user = new Strukt\User();
	$user->setUsername($session->get("username"));

	return $user;
});

$kernel->providers(array(

	Strukt\Framework\Provider\Annotation::class,
	Strukt\Framework\Provider\Router::class
));

$kernel->middlewares(array(
	
	"execption" => new ExceptionHandler(Env::get("is_dev")),
	"session" => new SessionMiddleware(new Session()),
	"authorization" => new Authorization($kernel->core()->get("app.dep.author")),
	"authentication" => new Authentication($kernel->core()->get("app.dep.authetic")),
	"staticfinder" => new StaticFileFinder(Env::get("root_dir"), Env::get("rel_static_dir")),
	"router" => new Router,
));

App\Loader::getApp($kernel)->runDebug();