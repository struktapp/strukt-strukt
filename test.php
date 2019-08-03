<?php

require "vendor/autoload.php";

$f = explode("\n", Strukt\Fs::cat("backup/index.php.tpl"));

foreach($f as $g){

	if(!preg_match("/\/\/(strukt-do|strukt-strukt)/", $g)){

		$h[] = $g;
	}
}

print_r(implode("\n", $h));