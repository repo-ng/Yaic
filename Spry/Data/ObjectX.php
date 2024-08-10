<?php //*** ObjectX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Spry\Data;

use App\Yaic\Orig\Can;


class ObjectX
{

	// • === is → ... » boolean
	public static function is($object)
	{
		return is_object($object);
	}





	// • === empty → is object & empty » boolean
	public static function empty(&$var)
	{
		return is_object($var) && empty(get_object_vars($var));
	}





	// • === append → ... » boolean
	public static function append(&$object, $param)
	{
		if (Can::iterate($param)) {
			if (empty($object)) {
				$object = new \stdClass();
			} elseif (!is_object($object)) {
				return false;
			}
			foreach ($param as $key => $value) {
				$object->{$key} = $value;
			}
			return true;
		}
		return false;
	}

}//> end of ObjectX