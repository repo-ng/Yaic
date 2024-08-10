<?php //*** EnvX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Spry;


class PathX
{

	// • property
	private static $separator;





	// • === init → ... » []
	private static function init()
	{
		self::$separator = DIRECTORY_SEPARATOR;
	}





	// • === app → ... » []
	public static function app($path = '')
	{
		return app_path($path);
	}





	// • === base → ... » []
	public static function base($path = '')
	{
		return base_path($path);
	}





	// • === config → ... » []
	public static function config($path = '')
	{
		return config_path($path);
	}





	// • === database → ... » []
	public static function database($path = '')
	{
		return database_path($path);
	}





	// • === lang → ... » []
	public static function lang($path = '')
	{
		return lang_path($path);
	}





	// • === public → ... » []
	public static function public($path = '')
	{
		return public_path($path);
	}





	// • === resource → ... » []
	public static function resource($path = '')
	{
		return resource_path($path);
	}





	// • === storage → ... » []
	public static function storage($path = '')
	{
		return storage_path($path);
	}





	// • === router → ... » []
	public static function router($path = 'zero')
	{
		self::init();
		$directory = self::base() . self::$separator . 'routes' . self::$separator;
		if (!empty($path)) {
			if ($path === 'zero::api') {
				$directory .= 'zero' . self::$separator . 'api.php';
			} elseif ($path === 'zero::web') {
				$web['app'] = $directory . 'zero' . self::$separator . 'app.php';
				$web['site'] = $directory . 'zero' . self::$separator . 'site.php';
				$web['zero'] = $directory . 'zero' . self::$separator . 'zero.php';
				return $web;
			} else {
				$directory .= $path . self::$separator;
			}
		}
		return $directory;
	}





	// • === inc → ... » []
	public static function inc($path, $to = null)
	{
		if (!empty($to)) {
			if ($to === 'router') {
				$file = self::router($path);
			}
		}
		$file = !empty($file) ? $file : $path;

		if (is_array($file)) {
			foreach ($file as $filename) {
				if (is_file($filename)) {
					require $filename;
				}
			}
		} elseif (is_file($file)) {
			require $file;
		}
	}

}//> end of PathX