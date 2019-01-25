<?php

namespace App\Command;

use Strukt\Console\Input;
use Strukt\Console\Output;

/**
* shell:exec  Strukt Shell Mode
*/
class ShellExec extends \Strukt\Console\Command{

	public function execute(Input $in, Output $out){

		$registry = \Strukt\Core\Registry::getInstance();
		$nr = $registry->get("nr");
		$core = $registry->get("core");

		// $sh = new \Psy\Shell(new \Psy\Configuration(array("startupMessage"=>"\nStrukt Shell\n")));
		$sh = new \Psy\Shell();
		$sh->setScopeVariables(compact('core', 'registry'));
		// $sh->setScopeVariables(get_defined_vars());
		$sh->run();
	}
}
