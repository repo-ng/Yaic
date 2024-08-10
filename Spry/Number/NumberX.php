<?php //*** NumberX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Spry\Number;

use App\Zero\Spry\Data\StringX;

class NumberX
{
	// • === isEven → check if number is even » boolean
	public static function isEven($number)
	{
		return ($number % 2 == 0);
	}





	// • === isOdd → check if number is odd » boolean
	public static function isOdd($number)
	{
		return (!self::isEven($number));
	}




	// • === format → ... »
	public static function format($number, $decimal = 0, $separator = ',', $pointer = '.')
	{
		return number_format($number, $decimal, $pointer, $separator);
	}





	// • === decimal → ... »
	public static function decimal($number, $flag = 'NUMBER')
	{
		$numberIs = strval($number);
		$decimalNumbers = StringX::after($number, '.');

		if ($flag === 'NUMBER') {
			$decimalNumbers = $decimalNumbers ?? false;
			return $decimalNumbers;
		}

		if (!empty($decimalNumbers)) {
			return strlen($decimalNumbers);
		}

		return 0;
	}





	// • === decimalCount → ... »
	public static function decimalCount($number)
	{
		return self::decimal($number, 'COUNT');
	}




	// • === round → ... »
	public static function round($number, $decimal = 2)
	{
		$number = round($number, $decimal);
		return (float) $number;
	}





	// • === decimalAmountFormat → ... »
	public static function decimalAmountFormat($amount, $decimal = 2, $padding = false)
	{
		$decimalCount = self::decimalCount($amount);
		if ($decimalCount > $decimal) {
			return self::round($amount, $decimal);
		} elseif ($decimalCount === $decimal) {
			return $amount;
		} elseif ($decimalCount < 1) {
			return $amount . '.00';
		} elseif ($decimalCount < $decimal) {
			if ($padding === true) {
				$difference = ($decimal - $decimalCount);
				for ($i = 0; $i < $difference; $i++) {
					$amount .= '0';
				}
			}
		}
		return $amount;
	}

}//> end of NumberX