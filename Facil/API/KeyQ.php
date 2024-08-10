<?php //*** KeyQ » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Facil\API;

use Illuminate\Http\Request;
use App\Yaic\Spry\EnvX;


class KeyQ
{

	// • property
	private static $key;





	// • === require → ... » []
	public static function require(Request $request, $var = 'key')
	{
		$key = $request->header($var);
		if (!$key) {
			return ResponseQ::requireKey();
		}
		self::$key = $key ?? false;
		return true;
	}





	// • === validate → ... » []
	public static function validate($key = null)
	{
		if (is_null($key) || $key === 'KEY') {
			$key = EnvX::project('key');
		}
		if (!empty($key)) {
			if ($key === self::$key) {
				return true;
			}
		}
		return ResponseQ::invalidKey();
	}





	// • === is → ... » []
	public static function is($key = null)
	{
		if (!is_null($key) && !empty($key)) {
			return self::$key === $key;
		}
		return self::$key;
	}

}//> end of KeyQ