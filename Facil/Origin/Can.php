<?php //*** Can » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Facil\Origin;


class Can
{

	// • === iterate → ... » boolean
	public static function iterate(&$var)
	{
		return is_iterable($var);
	}





	// • === string → ... » boolean
	public static function string(&$var)
	{
		if (!blank($var)) {

			// @ is scalar [string, integer, float, or boolean]
			if (is_scalar($var)) {
				return true;
			}

			// @ is an object that implements __toString
			if (is_object($var) && method_exists($var, '__toString')) {
				return true;
			}
		}

		return false;
	}

}//> end of Can