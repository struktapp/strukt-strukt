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

use Strukt\Framework\Provider\Validator as ValidatorProvider;
use Strukt\Framework\Provider\Annotation as AnnotationProvider;
use Strukt\Framework\Provider\Router as RouterProvider;

/** //strukt-do
use App\Provider\Logger as LoggerProvider;
use App\Provider\EntityManager as EntityManagerProvider;
use App\Provider\EntityManagerAdapter as EntityManagerAdapterProvider;
use App\Provider\Normalizer as NormalizerProvider;
use Cobaia\Doctrine\MonologSQLLogger;
**/ //strukt-do//

/** //strukt-audit
use App\Middleware\Audit as AuditMiddleware;
**/ //strukt-audit//

use Strukt\Event\Event;
use Strukt\Env;

Env::set("root_dir", getcwd());
Env::set("rel_app_ini", "/cfg/app.ini");
Env::set("rel_static_dir", "/public/static");
Env::set("rel_mod_ini", "/cfg/module.ini");
Env::set("is_dev", true);

/** //strukt-do
Env::set("rel_appsrc_dir", "app/src/");
Env::set("rel_db_ini", "cfg/db.ini");
Env::set("logger_name", "Strukt Logger");
Env::set("logger_file", "logs/app.log");
**/ //strukt-do//

$kernel = new Strukt\Router\Kernel(Request::createFromGlobals());
$kernel->inject("app.dep.author", function(){

	return array(

		"permissions" => array(

			// "show_secrets"
			// "user_all"
		)
	);
});

/** //strukt-do
$kernel->inject("app.dep.logger.sqllogger", function(){

	return new MonologSQLLogger(null, null, __DIR__ . '/logs/');
});
**/ //strukt-do//

/** //strukt-roles
$kernel->inject("app.dep.author", function(Session $session){

	if($session->has("username")){

		$userC = new __APP__\AuthModule\Controller\User;
		$permissions = $userC->findPermissionsByUsername($session->get("username"));

		return $permissions;
	}

	return array();
});
**/ //strukt-roles//

/**/ //strukt-strukt//
$kernel->inject("app.dep.authentic", function(Session $session){

	$user = new Strukt\User();
	$user->setUsername($session->get("username"));

	return $user;
});
/**/ //strukt-strukt//

$kernel->inject("app.dep.session", function(){

	return new Session;
});

$kernel->providers(array(

	ValidatorProvider::class,
	AnnotationProvider::class,
	RouterProvider::class

	/** //strukt-do
	LoggerProvider::class,
	EntityManagerProvider::class,
	EntityManagerAdapterProvider::class,
	NormalizerProvider::class
	**/ //strukt-do//
));

$kernel->middlewares(array(
	
	ExceptionHandler::class,
	SessionMiddleware::class,
	Authorization::class,
	Authentication::class,
	StaticFileFinder::class,
	/** //strukt-audit
	AuditMiddleware::class,
	**/ //strukt-audit//
	RouterMiddleware::class
));

$loader = new App\Loader($kernel);
$app = $loader->getApp(); 
$app->runDebug();