<?php

namespace App\Middleware;

use Strukt\Contract\ResponseInterface;
use Strukt\Http\Request;
use Strukt\Contract\MiddlewareInterface;
use Strukt\Contract\AbstractMiddleware;

class Cors extends AbstractMiddleware implements MiddlewareInterface{

	public function __construct(){

		//
	}

	public function __invoke(Request $request, ResponseInterface $response, callable $next){

    	$response->headers->add([

    		"Access-Control-Allow-Origin" => "*",
    		"Access-Control-Allow-Headers" => "X-Requested-With, Content-Type, Accept",
    		"Access-Control-Allow-Methods" => "GET,POST,PUT,DELETE"
		]);

    	return $next($request, $response);
	}
}