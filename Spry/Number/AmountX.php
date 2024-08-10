<?php //*** AmountX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Spry\Number;

use App\Yaic\Spry\Data\StringX;
use Illuminate\Support\Number;


class AmountX
{

	// • === toHundred → ... »
	private static function toHundred($amount)
	{
		$amount = strtolower(trim($amount));
		if (StringX::contain($amount, 'hundred')) {
			$beforeHundred = StringX::beforeAs($amount, 'hundred', false);
			$afterHundred = StringX::afterFirst($amount, 'hundred');
			if (!empty($afterHundred)) {
				$afterHundred = trim($afterHundred);
				if (StringX::notBeginWithAny($afterHundred, ['trillion', 'thousand'])) {
					$afterHundred = ' and ' . $afterHundred;
				}
			}
			return $beforeHundred . ' ' . trim($afterHundred);
		}
		return $amount;
	}





	// • === unit → ... »
	private static function unit(&$naira, &$unit, $label, &$amount = null)
	{
		$unit = StringX::before($naira, $label, false);
		if (!empty($unit)) {
			$naira = StringX::after($naira, $label);
			$unit = trim($unit);
			$unit = self::toHundred($unit);
		}

		if ($amount !== null) {
			if (!empty($unit)) {
				$amount .= (empty($amount) ? '' : ', ') . trim($unit);
			}
		}
	}





	// • === trillion → ... »
	private static function trillion(&$naira, &$trillion, &$amount)
	{
		self::unit($naira, $trillion, 'trillion', $amount);
	}





	// • === billion → ... »
	private static function billion(&$naira, &$billion, &$amount)
	{
		self::unit($naira, $billion, 'billion', $amount);
	}





	// • === million → ... »
	private static function million(&$naira, &$million, &$amount)
	{
		self::unit($naira, $million, 'million', $amount);
	}





	// • === thousand → ... »
	private static function thousand(&$naira, &$thousand, &$amount)
	{
		self::unit($naira, $thousand, 'thousand', $amount);
	}





	// • === hundred → ... »
	private static function hundred(&$naira, &$hundred)
	{
		self::unit($naira, $hundred, 'hundred');
	}





	// • === naira → ... »
	private static function naira(&$naira, &$amount)
	{
		if (!empty($naira)) {
			$naira = self::toHundred($naira);
			$naira .= ' naira';
			if (!empty($naira)) {
				$amount .= (empty($amount) ? '' : ', ') . trim($naira);
			}
		} elseif (!empty($amount)) {
			$amount = trim($amount) . ' naira';
		}
	}





	// • === kobo → ... »
	private static function kobo($number, &$amount)
	{
		$kobo = StringX::after($number, '.');
		if ($kobo != '0' && $kobo != '00') {
			$kobo = !empty($kobo) ? Number::spell($kobo) : $kobo;
		} else {
			$kobo = null;
		}

		if (!empty($kobo)) {
			if (!empty($amount) && StringX::endWith($amount, 'naira')) {
				$amount .= ', and';
			}
			$amount .= ' ' . $kobo . ' kobo';
		}

		return $kobo;
	}





	// • === format → ... »
	public static function format($number, $precision = 2)
	{
		return Number::format($number, precision: $precision);
	}





	// • === inNaira → ... »
	public static function inNaira($number)
	{

		// » prepare
		$number = StringX::strip($number, ',');
		$naira = StringX::beforeAs($number, '.');
		$naira = !empty($naira) ? Number::spell($naira) : $naira;
		$amount = '';


		// » trillion
		$trillion = null;
		self::trillion($naira, $trillion, $amount);


		// » billion
		$billion = null;
		self::billion($naira, $billion, $amount);


		// » million
		$million = null;
		self::million($naira, $million, $amount);


		// » thousand
		$thousand = null;
		self::thousand($naira, $thousand, $amount);


		// » naira
		self::naira($naira, $amount);


		// » kobo
		self::kobo($number, $amount);


		//$figure = self::format($number);
		//$onion = compact('figure', 'thousand', 'naira', 'amount');

		return $amount;
	}





	// • === inDollar → ... »
	public static function inDollar($number, $prefix = 'US', $decimal = 'cent')
	{
		$words = self::inNaira($number);
		if ($number > 1) {
			$prefix .= ' dollars';
		} else {
			$prefix .= ' dollar';
		}
		$words = StringX::swap($words, 'naira', $prefix);
		$words = StringX::swap($words, 'kobo', $decimal);
		return $words;
	}

}//> end of AmountX