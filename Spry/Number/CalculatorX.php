<?php //*** CalculatorX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Spry\Number;


class CalculatorX
{
	// • === quantityAmount → ... »
	public static function quantityAmount($quantity, $price)
	{
		$calculation = ($quantity * $price);
		return NumberX::decimalAmountFormat($calculation);
	}





	// • === plus → ... »
	public static function plus($amount, $more)
	{
		$calculation = ($amount + $more);
		return NumberX::decimalAmountFormat($calculation);
	}





	// • === minus → ... »
	public static function minus($amount, $less)
	{
		$calculation = ($amount - $less);
		return NumberX::decimalAmountFormat($calculation);
	}





	// • === percentage → ... »
	public static function percentage($amount, $percentage)
	{
		$calculation = ($percentage / 100) * $amount;
		return NumberX::decimalAmountFormat($calculation);
	}





	// • === percentageOf → ... »
	public static function percentageOf($amount, $total)
	{
		return ($amount / $total) * 100;
	}





	// • === VAT → ... »
	public static function VAT($amount, $percentage = '7.5')
	{
		return self::percentage($amount, $percentage);
	}





	// • === holdingTax → ... »
	public static function holdingTax($amount, $percentage = '5')
	{
		return self::percentage($amount, $percentage);
	}

}//> end of CalculatorX