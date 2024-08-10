<?php //*** StringX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Spry\Data;

use App\Yaic\Orig\Is;
use App\Yaic\Orig\Can;
use App\Yaic\Orig\Has;


class StringX
{

	// • === is → ... » boolean
	public static function is($string, $strict = false)
	{
		if ($strict === true) {
			return Is::string($string);
		}
		return Can::string($string);
	}





	// • === isNot → is not string » boolean
	public static function isNot($string, $strict = false)
	{
		return !self::is($string, $strict);
	}





	// • === empty → is string & empty » boolean
	public static function empty(&$var)
	{
		return self::is($var) && strlen($var) < 1;
	}





	// • === notEmpty → is string & not empty » boolean
	public static function notEmpty(&$var)
	{
		return self::is($var) && strlen($var) >= 1;
	}





	// • === in → ... » boolean
	public static function in($string, $needle, $strictCase = true)
	{
		if (self::notEmpty($string)) {
			if ($strictCase) {
				if ($needle === $string) {
					return true;
				} elseif (strpos($string, $needle) !== false) {
					return true;
				}
			} else {
				if ($needle == $string) {
					return true;
				} elseif (stripos($string, $needle) !== false) {
					return true;
				}
			}
		}
		return false;
	}





	// • === contain → check in string (case insensitive) » boolean
	public static function contain($string, $needle)
	{
		if (self::notEmpty($string)) {
			if (strtolower($needle) === 'space' && strpos($string, ' ') !== false) {
				return true;
			}
			if (self::in($string, $needle, false)) {
				return true;
			}
		}
		return false;
	}





	// • === compare → compare string » boolean
	public static function compare($string, $needle, $strict = true)
	{
		if (self::is($string) && self::is($needle)) {
			if (strtolower($string) == strtolower($needle) && !$strict) {
				return true;
			} elseif ($string === $needle && $strict) {
				return true;
			}
		}
		return false;
	}





	// • === nth → nth character » string
	public static function nth($string, $nth)
	{
		if (self::notEmpty($string) && is_numeric($nth)) {
			$length = strlen($string);
			if ($nth <= $length) {
				$nth = (int) $nth - 1;
				return $string[$nth];
			}
		}
		return false;
	}





	// • === first → first character (nth) » string
	public static function first($string, $nth = 1)
	{
		if (self::notEmpty($string) && is_numeric($nth)) {
			$length = strlen($string);
			if ($nth <= $length) {
				return substr($string, 0, $nth);
			}
		}
		return false;
	}





	// • === last → last character (nth) » string
	public static function last($string, $nth = 1)
	{
		if (self::notEmpty($string) && is_numeric($nth)) {
			$length = strlen($string);
			if ($nth <= $length) {
				return substr($string, -$nth);
			}
		}
		return false;
	}





	// • === occurrence → count » boolean, number
	public static function occurrence($string, $needle, $offset = 0, $length = null)
	{
		if (self::notEmpty($string)) {
			$stringLength = strlen($string);
			if ($length > $stringLength) {
				$length = $stringLength;
			}
			return substr_count($string, $needle, $offset, $length);
		}
		return false;
	}





	// • === occurrenceNth → ... »
	public static function occurrenceNth($string, $separator, $nth, $req = 'nth')
	{
		$occurrence = [];
		$parts = explode($separator, $string);
		for ($i = 0; $i < count($parts); $i = $i + $nth) {
			$occurrence[] = implode($separator, array_slice($parts, $i, $i + $nth));
		}
		if (strtolower($req) === 'nth') {
			return $occurrence[$nth - 1];
		}
		return $occurrence;
	}





	// • === swap → replacement »
	public static function swap($string, $needle, $substitute, $occurrence = 'all', $strictCase = false)
	{
		if (self::in($string, $needle, $strictCase)) {
			if (strtolower($occurrence) === 'all') {
				if ($strictCase) {
					$string = str_replace($needle, $substitute, $string);
				} else {
					$string = str_ireplace($needle, $substitute, $string);
				}
			} else {
				if (strtolower($occurrence) === 'first') {
					if ($strictCase) {
						$pos = strpos($string, $needle);
					} else {
						$pos = stripos($string, $needle);
					}
				}
				if (strtolower($occurrence) === 'last') {
					if ($strictCase) {
						$pos = strrpos($string, $needle);
					} else {
						$pos = strripos($string, $needle);
					}
				}
				if ($pos !== false) {
					return substr_replace($string, $substitute, $pos, strlen($needle));
				}
			}
		}
		return $string;
	}





	// • === swapFirst → replace first occurrence »
	public static function swapFirst($string, $needle, $substitute = '', $strictCase = false)
	{
		return self::swap($string, $needle, $substitute, 'first', $strictCase);
	}





	// • === swapLast → replace last occurrence »
	public static function swapLast($string, $needle, $substitute = '', $strictCase = false)
	{
		return self::swap($string, $needle, $substitute, 'last', $strictCase);
	}





	// • === swapSpace → replace space character & vice-versa »
	public static function swapSpace($string, $needle, $inverse = false)
	{
		if (self::notEmpty($string) && self::is($needle)) {
			if (!$inverse && self::contain($string, 'space')) {
				return self::swap($string, ' ', $needle);
			} elseif ($inverse && self::contain($string, $needle)) {
				return self::swap($string, $needle, ' ');
			}
			return $string;
		}
		return false;
	}





	// • === strip → remove from occurrence from string »
	public static function strip($string, $needle, $strictCase = false)
	{
		return self::swap($string, $needle, '', 'all', $strictCase);
	}




	// • === stripFirst → remove from first occurrence from string »
	public static function stripFirst($string, $needle, $strictCase = false)
	{
		return self::swapFirst($string, $needle, '', $strictCase);
	}




	// • === stripLast → remove from last occurrence from string »
	public static function stripLast($string, $needle, $strictCase = false)
	{
		return self::swapLast($string, $needle, '', $strictCase);
	}





	// • === crop → trim edges or character(s) »
	public static function crop($string, $needle = 'space', $strictCase = false)
	{
		if (self::notEmpty($string) && self::notEmpty($needle)) {
			if (strtolower($needle) === 'space') {
				return trim($string);
			} elseif (self::in($string, $needle, $strictCase)) {
				$string = trim($string);
				return trim($string, $needle);
			}
			return $string;
		}
		return false;
	}




	// • === cropBegin → remove beginning of string »
	public static function cropBegin($string, $needle, $strictCase = false)
	{
		if (self::beginWith($string, $needle)) {
			return self::stripFirst($string, $needle, $strictCase);
		}
		return $string;
	}




	// • === cropEnd → remove end of string »
	public static function cropEnd($string, $needle, $strictCase = false)
	{
		if (self::endWith($string, $needle)) {
			return self::stripLast($string, $needle, $strictCase);
		}
		return $string;
	}





	// • === singleSpace → ... » boolean
	public static function singleSpace($string)
	{
		return preg_replace('/\s+/', ' ', $string);
	}





	// • === noSpace → ... » boolean
	public static function noSpace($string)
	{
		return self::swap($string, ' ', '');
	}





	// • === noChar → remove special characters
	public static function noChar($string, $append = null)
	{
		if (self::notEmpty($string)) {
			$pattern = "A-Za-z0-9\-";
			if (is_array($append) && !empty($append)) {
				foreach ($append as $char) {
					$pattern .= $char;
				}
			} elseif (self::notEmpty($append)) {
				$pattern .= $append;
			}
			return preg_replace('/[^' . $pattern . ']/', '', $string);
		}
		return false;
	}





	// • === before → string before character
	public static function before($string, $needle, $strip = true, $strictCase = false)
	{
		if (self::notEmpty($string) && self::in($string, $needle, $strictCase)) {
			if (!$strictCase) {
				$pos = stripos($string, $needle);
			} else {
				$pos = strpos($string, $needle);
			}
			if ($pos && $pos != 0) {
				$res = substr($string, 0, $pos);
			}
			if (!$strip) {
				$res = $res . $needle;
			}
			if (isset($res)) {
				return $res;
			}
		}
		return false;
	}





	// • === beforeAs → string before character or the string
	public static function beforeAs($string, $needle, $strip = true, $strictCase = false)
	{
		$stringBefore = self::before($string, $needle, $strip, $strictCase);
		if ($stringBefore === false) {
			return $string;
		}
		return $stringBefore;
	}





	// • === after → string after character
	public static function after($string, $needle, $strip = true, $strictCase = false, $occurrence = 'first')
	{
		if (self::notEmpty($string) && self::in($string, $needle, $strictCase)) {
			if ($strictCase) {
				$string = strstr($string, $needle);
			} else {
				$string = stristr($string, $needle);
			}
			if ($string !== false) {
				if ($strip === true && strtolower($occurrence) === 'first') {
					$string = self::swapFirst($string, $needle, '', $strictCase);
				} elseif (strtolower($occurrence) === 'last') {
					if ($strictCase) {
						$pos = strrpos($string, $needle);
					} else {
						$pos = strripos($string, $needle);
					}
					if ($pos !== false) {
						$string = substr($string, $pos + strlen($needle));
					}
					if ($strip === false) {
						$string = $needle . $string;
					}
				}
				return $string;
			}
		}
		return false;
	}





	// • === afterFirst → string after first occurrence of a character » string, false
	public static function afterFirst($string, $needle, $strip = true, $strictCase = false)
	{
		return self::after($string, $needle, $strip, $strictCase, 'first');
	}





	// • === afterLast → string after last occurrence of a character » string, false
	public static function afterLast($string, $needle, $strip = true, $strictCase = false)
	{
		return self::after($string, $needle, $strip, $strictCase, 'last');
	}





	// • === afterAs → string after character or the string
	public static function afterAs($string, $needle, $strip = true, $strictCase = false, $occurrence = 'FIRST')
	{
		$stringAfter = self::after($string, $needle, $strip, $strictCase, $occurrence);
		if ($stringAfter === false) {
			return $string;
		}
		return $stringAfter;
	}





	// • === afterFirstAs → string after character or the string
	public static function afterFirstAs($string, $needle, $strip = true, $strictCase = false)
	{
		$stringAfter = self::afterFirst($string, $needle, $strip, $strictCase);
		if (!$stringAfter) {
			return $string;
		}
		return $stringAfter;
	}





	// • === afterLastAs → string after character or the string
	public static function afterLastAs($string, $needle, $strip = true, $strictCase = false)
	{
		$stringAfter = self::afterLast($string, $needle, $strip, $strictCase);
		if (!$stringAfter) {
			return $string;
		}
		return $stringAfter;
	}





	// • === blur → blur censored character & vice-versa
	public static function blur($string, $library, $blur = '***', $strictCase = false)
	{
		if (self::notEmpty($string) && !empty($library)) {
			$words = explode(" ", $string);
			if (!is_array($library)) {
				if (self::contain($library, '|')) {
					$library = self::swap($library, ' | ', '|');
					$library = explode('|', $library);
				} elseif (self::contain($library, '-')) {
					$library = self::swap($library, ' - ', '-');
					$library = explode('-', $library);
				} elseif (self::contain($library, ',')) {
					$library = self::swap($library, ' , ', ',');
					$library = explode(',', $library);
				} else {
					$library = explode(' ', $library);
				}
			}
			foreach ($words as $word) {
				if (in_array(strtolower($word), array_map('strtolower', $library))) {
					$string = self::swap($string, $word, $blur, 'all', $strictCase);
				}
			}
			return $string;
		}
		return false;
	}





	// • === isUppercase → is string upper case » boolean
	public static function isUppercase($string)
	{
		return Is::uppercase($string);
	}




	// • === isLowercase → is string lower case » boolean
	public static function isLowercase($string)
	{
		return Is::lowercase($string);
	}




	// • === isMixedcase → is string lower & upper case » boolean
	public static function isMixedcase($string)
	{
		return Is::mixedcase($string);
	}




	// • === isNumbers → is string numbers » boolean
	public static function isNumber($string)
	{
		return Is::number($string);
	}





	// • === hasNumber → string contains numbers »
	public static function hasNumber($string)
	{
		return Has::number($string);
	}





	// • === hasLetter → string contains letters »
	public static function hasLetter($string)
	{
		return Has::letter($string);
	}





	// • === hasSpace → string has space »
	public static function hasSpace($string)
	{
		return Has::space($string);
	}





	// • === hasNewline → string has newline »
	public static function hasNewline($string)
	{
		return Has::newline($string);
	}





	// • === hasParagraph → string has multiple consecutive newline »
	public static function hasParagraph($string)
	{
		return Has::paragraph($string);
	}






	// • === begin → check string beginning » boolean
	public static function beginWith($string, $begin)
	{
		if (self::notEmpty($string) && self::notEmpty($begin)) {
			$string = trim($string);
			if (function_exists('str_starts_with')) {
				return str_starts_with($string, $begin);
			} else {
				return strpos($string, $begin) === 0;
			}
		}
		return false;
	}





	// • === beginWithAny → check if string begin with anything in array or comma separated string » string, boolean
	public static function beginWithAny($string, $begins)
	{

		if (is_string($begins)) {
			if (self::contain($begins, ',')) {
				$begins = explode(',', $begins);
			} elseif (self::beginWith($string, $begins)) {
				return $begins;
			}
		}

		foreach ($begins as $prefix) {
			if (substr($string, 0, strlen($prefix)) === $prefix) {
				return $prefix;
			}
		}

		return false;
	}





	// • === notBeginWith → ... »
	public static function notBeginWith($string, $begin)
	{
		return (self::beginWith($string, $begin) === false);
	}





	// • === notBeginWithAny → ... »
	public static function notBeginWithAny($string, $begins)
	{
		return (self::beginWithAny($string, $begins) === false);
	}





	// • === endWith → check string ending » boolean
	public static function endWith($string, $end)
	{
		if (self::notEmpty($string) && self::notEmpty($end)) {
			$string = trim($string);
			if (function_exists('str_ends_with')) {
				return str_ends_with($string, $end);
			} else {
				$length = strlen($end);
				return $length > 0 ? substr($string, -$length) === $end : true;
			}
		}
		return false;
	}





	// • === endWithAny → check if string ends with anything in array or comma separated string » string, boolean
	public static function endWithAny($string, $endings)
	{

		if (is_string($endings)) {
			if (self::contain($endings, ',')) {
				$endings = explode(',', $endings);
			} elseif (self::endWith($string, $endings)) {
				return $endings;
			}
		}

		for ($i = count($endings) - 1; $i >= 0; $i--) {
			$suffix = $endings[$i];
			if (substr($string, -strlen($suffix)) === $suffix) {
				return $suffix;
			}
		}

		return false;
	}





	// • === notBeginWith → ... »
	public static function notEndWith($string, $begin)
	{
		return (self::endWith($string, $begin) === false);
	}





	// • === notBeginWithAny → ... »
	public static function notEndWithAny($string, $begins)
	{
		return (self::endWithAny($string, $begins) === false);
	}





	// • === pattern → return regex pattern » string
	private static function pattern($pattern)
	{
		if (self::notEmpty($pattern)) {
			$pattern = strtolower($pattern);

			// → predefined pattern
			$patterns = [
				'uppercase' => "/^[A-Z]+$/",
				'lowercase' => "/^[a-z]+$/",
				'alpha' => "/^[A-Z]+$/i",
				'numeric' => "/^[0-9]+$/",
				'alphanumeric' => "/^[A-Z0-9]+$/i",
			];

			if (isset($patterns[$pattern])) {
				$pattern = $patterns[$pattern];
			}
		}
		return $pattern;
	}





	// • === pattern → match pattern » boolean, string, array
	public static function match($string, $pattern, $return = 'boolean', $flags = 0, $offset = 0)
	{
		if (self::notEmpty($string)) {
			$pattern = self::pattern($pattern);

			// → clean up pattern
			if (self::notBeginWith($pattern, '/')) {
				$pattern = '/' . $pattern;
			}
			if (self::notEndWith($pattern, '/')) {
				$pattern = $pattern . '/';
			}

			if ($return === 'matches' || $return === 'count') {
				$preg = preg_match_all($pattern, $string, $match, $flags, $offset);
			} else {
				$preg = preg_match($pattern, $string, $match, $flags, $offset);
			}

			if ($preg !== false) {
				if ($return === 'boolean' && $preg > 0) {
					return true;
				} elseif ($return === 'match' && $preg > 0 && is_array($match)) {
					return $match[0];
				} elseif ($return === 'matches' && $preg > 0 && is_array($match)) {
					return $match;
				} elseif ($return === 'count' && $preg > 0) {
					return $preg;
				}
			}
		}
		return false;
	}





	// • === toObject → string to object »
	public static function toObject($string, $separator, $keySeparator)
	{
		$pairs = explode($separator, trim($string));
		$object = new \stdClass();
		if (is_array($pairs) && !empty($pairs)) {
			foreach ($pairs as $pair) {
				$pair = trim($pair);
				if (!empty($pair)) {
					list($key, $value) = array_map('trim', explode($keySeparator, $pair, 2));
					$object->$key = $value;
				}
			}
		}
		return $object;
	}






	// • === toArray → string to array »
	public static function toArray($string, $separator = null)
	{
		if (self::notEmpty($string)) {
			if (is_null($separator)) {
				$array = str_split($string);
			}

			if ($separator === 'space') {
				$array = array_map('trim', explode(' ', $string));
			}

			if (self::notEmpty($string)) {
				$array = array_map('trim', explode($separator, $string));
			}

			if (isset($array)) {
				return $array;
			}
		}
		return false;
	}





	// • === toUppercase →
	public static function toUppercase($string)
	{
		if (self::is($string)) {
			return strtoupper($string);
		}
		return false;
	}




	// • === toLowercase →
	public static function toLowercase($string)
	{
		if (self::is($string)) {
			return strtolower(trim($string));
		}
		return false;
	}




	// • === toSentenceCase →
	public static function toSentenceCase($string)
	{
		if (self::is($string)) {
			return ucfirst(strtolower($string));
		}
		return false;
	}





	// • === toSnakeCase →
	public static function toSnakeCase($string, $separator = null)
	{
		if (!empty($separator)) {
			$words = explode($separator, $string);
		} else {
			$words = explode(' ', $string);
		}
		foreach ($words as $key => $word) {
			if (self::isUppercase($word)) {
				$words[$key] = strtolower($word);
			}
		}
		$string = implode(' ', $words);
		$string = preg_replace('/\s+/u', '', ucwords($string));
		$string = preg_replace('/(.)(?=[A-Z])/u', '$1_', $string);
		return strtolower($string);
	}





	// • === toCamelCase →
	public static function toCamelCase($string, $separator = null)
	{
		if (!empty($separator)) {
			$words = explode($separator, $string);
			foreach ($words as $key => $word) {
				if (self::isUppercase($word)) {
					$words[$key] = strtolower($word);
				}
				$string = implode(' ', $words);
			}
		}
		$string = preg_replace('/[^a-zA-Z0-9]+/', ' ', $string);
		$string = strtolower($string);
		$string = ucwords($string);
		$string = str_replace(' ', '', $string);
		$string = lcfirst($string);
		return $string;
	}





	// • === toCapitalize →
	public static function toCapitalize($string)
	{
		return ucwords(self::toSentenceCase($string));
	}





	// • === uppercaseCount →
	public static function uppercaseCount($string)
	{
		$pattern = '/[A-Z]/';
		return preg_match_all($pattern, $string);
	}





	// • === uppercaseToSpace →
	public static function uppercaseToSpace($string)
	{
		return preg_replace('/([a-z])([A-Z])/', '$1 $2', $string);
	}





	// • === getUppercase → get upper case letter & positions » array, boolean [false]
	public static function getUppercase($string)
	{
		preg_match_all('/[A-Z]/', $string, $matches, PREG_OFFSET_CAPTURE);
		if (!empty($matches[0])) {
			$matches = $matches[0];
			$upperCase = [];
			foreach ($matches as $match) {
				$upperCase[$match[1]] = $match[0];
			}
			return $upperCase;
		}
		return false;
	}





	// • === getLowercase → get lower case letter & positions » array, boolean [false]
	public static function getLowercase($string)
	{
		preg_match_all('/[a-z]/', $string, $matches, PREG_OFFSET_CAPTURE);
		if (!empty($matches[0])) {
			$matches = $matches[0];
			$upperCase = [];
			foreach ($matches as $match) {
				$upperCase[$match[1]] = $match[0];
			}
			return $upperCase;
		}
		return false;
	}

}//> end of StringX