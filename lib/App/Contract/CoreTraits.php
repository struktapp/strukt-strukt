<?php

namespace App\Contract;

use Strukt\Core\Registry;

trait CoreTraits{

	public function core(){

		return Registry::getInstance();
	}

	protected function get($alias, Array $args = null){

		$core = self::core()->get("core");

		if(!empty($args))
			return $core->getNew($alias, $args);

		return $core->get($alias);
	}
}