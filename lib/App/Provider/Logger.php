<?php

namespace App\Provider;

use Monolog\Logger as Monolog;
use Monolog\Handler\StreamHandler;
use Strukt\Event;
use Strukt\Contract\AbstractProvider;
use Strukt\Contract\ProviderInterface;
use Strukt\Env;

class Logger extends AbstractProvider implements ProviderInterface{ 

	public function __construct(){

		//
	}

	public function register(){

		$this->core()->set("app.service.logger", new Event(function(
														$logger_name, 
														$log_file, 
														$log_type = Monolog::INFO){

			$logger = new Monolog($logger_name);
			$logger->pushHandler(new StreamHandler($log_file, $log_type));

			return $logger;
		}));

		$this->core()->set("app.logger", new class extends AbstractProvider{

			public function info($message, array $context = []){

				$logger = $this->core()->get("app.service.logger")
									->apply(Env::get("logger_name"), 
											Env::get("logger_file"))
									->exec();

				$logger->info($message, $context);
			}

			public function error($message, array $context = []){

				$logger = $this->core()->get("app.service.logger")
									->apply(Env::get("logger_name"), 
											Env::get("logger_file"),
											Monolog::ERROR)
									->exec();

				$logger->error($message, $context);
			}
		});	
	}
}

