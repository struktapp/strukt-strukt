<?php

namespace App\Middleware;

use Strukt\Contract\ResponseInterface;
use Strukt\Http\Request;
use Strukt\Contract\MiddlewareInterface;
use Strukt\Contract\AbstractMiddleware;

class Cors extends AbstractMiddleware implements MiddlewareInterface{

	public function __invoke(Request $request, ResponseInterface $response, callable $next){

    	// $response->headers->add([

    	// 	'Access-Control-Allow-Headers' => "Origin, X-Requested-With, Content-Type, Accept, Authorization",
    	// 	'Access-Control-Allow-Origin' => '*',
    	// 	'Access-Control-Allow-Methods' => '*'
    	// ]);


    	$response->headers->add([

    		"Access-Control-Allow-Origin" => "*",
    		"Access-Control-Allow-Headers" => "X-Requested-With, Content-Type, Accept",
    		"Access-Control-Allow-Methods" => "GET,POST,PUT,DELETE"

	    	// "Access-Control-Allow-Origin" => "http://localhost:8082",
			// "Access-Control-Allow-Methods" => "POST, GET, OPTIONS",
			// "Access-Control-Allow-Headers" => "Content-Type"
			// "Access-Control-Allow-Methods" => "*",
			// "Access-Control-Request-Headers" => "*",
			// "Access-Control-Allow-Credentials" => "true",
			// "Access-Control-Allow-Headers" => "*"
		]);

    	return $next($request, $response);
	}
}