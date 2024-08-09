<?php //*** Has » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Facil\Origin;


class Has
{

	// • === content → ... »
	public static function content(&$var)
	{
		return filled($var);
	}





	// • === number → ... »
	public static function number($var)
	{
		return (preg_match('/\d/', $var));
	}





	// • === letter → ... »
	public static function letter($var)
	{
		return (preg_match('/[a-zA-Z]/', $var));
	}





	// • === space → ...»
	public static function space($var)
	{
		return (strpos(trim($var), ' ') !== false);
	}





	// • === newline → ... »
	public static function newline($var)
	{
		return (strpos($var, "\n") !== false || strpos($var, "\r\n") !== false || strpos($var, "\r") !== false);
	}





	// • === paragraph → ... »
	public static function paragraph($var)
	{
		return (preg_match('/(\R){2,}/', $var));
	}

}//> end of Has