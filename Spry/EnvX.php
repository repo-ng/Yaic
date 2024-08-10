<?php //*** EnvX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Spry;

use App\Yaic\Spry\Data\StringX;
use Illuminate\Support\Facades\App;


class EnvX
{

	// • property
	private static $init = false;
	private static $env;
	private static $project;





	// • === init → ... »
	private static function init()
	{
		if (!self::$init) {
			self::$env = strtolower(App::environment());
			self::$init = true;

			// @ project
			self::$project = env('project');
			if (!empty(self::$project)) {
				self::$project = StringX::toObject(self::$project, ';', '=');
			}

		}
	}





	// • === is → ... »
	public static function is($env = null)
	{
		if ($env === null) {
			return self::$env;
		}

		if (!empty($env) && is_string($env)) {
			self::init();
			if (self::$env === strtolower($env)) {
				return true;
			}
		}

		return false;
	}





	// • === isDev → ... »
	public static function isDev()
	{
		return self::is('local');
	}





	// • === isStage → ... »
	public static function isStage()
	{
		return self::is('staging');
	}





	// • === isProd → ... »
	public static function isProd()
	{
		return self::is('production');
	}





	// • === project → ... »
	public static function project($key = null)
	{
		self::init();
		if (is_object(self::$project)) {
			if (!is_null($key) && isset(self::$project->${$key})) {
				return self::$project->${$key};
			}
		}
	}

}//> end of EnvX