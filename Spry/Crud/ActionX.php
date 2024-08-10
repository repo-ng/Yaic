<?php //*** ActionX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Spry\Crud;

use App\Yaic\Spry\Data\ArrayX;


class ActionX
{

	// • property
	private static $types = ['download', 'edit', 'clone', 'trash', 'delete'];





	// • === basic → ... » []
	public static function basic(array $exclude = [])
	{
		$actions = ['read'];
		return ArrayX::exclude($actions, $exclude);
	}





	// • === standard → ... » []
	public static function standard(array $exclude = [])
	{
		$actions = ['create', 'read', 'download'];
		return ArrayX::exclude($actions, $exclude);
	}





	// • === admin → ... » []
	public static function admin(array $exclude = [])
	{
		$actions = ['create', 'read', 'update', 'delete', 'clone', 'download'];
		return ArrayX::exclude($actions, $exclude);
	}





	// • === action → ... » []
	public static function action($type, array $exclude = [])
	{
		$type = strtolower($type);
		if (method_exists(self::class, $type)) {
			return self::$type($exclude);
		}
		return [];
	}





	// • === actionAsString → ... » []


}//> end of ActionX