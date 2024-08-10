<?php //*** Yaic » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Facil\Origin;


class Yaic
{

	// • constant
	const NAME = 'Yet Another Inventive Code';
	const ABBR = 'YAIC';
	const BRAND = 'YAIC™';





	// • === call → handler for undefined instance method »
	public function __call($method, $argument)
	{
		$caller = __CLASS__ . '→' . $method . '()';
		return self::oversight(__CLASS__, 'method undefined', $caller);
	}





	// • === callStatic → handler for undefined static method »
	public static function __callStatic($method, $argument)
	{
		$caller = __CLASS__ . '::' . $method . '()';
		return self::oversight(__CLASS__, 'static: method undefined', $caller);
	}





	// • === closure → ... »
	private static function closure($closure)
	{
		$reflection = new \ReflectionFunction($closure);
		return $reflection->getName();
	}





	// • === style → ... »
	private static function style($as)
	{

		switch ($as) {
			case 'label':
				$style = 'color:#FFD700;';
				break;

			case 'key':
				$style = 'color:#A52A2A;';
				break;

			case 'value':
				$style = 'color:#D2B48C; display: inline-block; padding-left: 2px;';
				break;

			case 'title':
				$style = 'color:#0F0F0F; margin:0; line-height:1.5; display:block;';
				break;

			case 'content':
				$style = 'color:purple;';
				break;

			case 'partition':
				$style = 'border-left: 1px dotted #FFD700; margin: 5px 8px; padding: 2px 6px; line-height:1.36';
				break;

			case 'container':
				$style = 'border: 1px dashed tan; padding: 5px 10px; margin-bottom:6px;';
				break;

			default:
				$style = '';
				break;
		}

		return $style;
	}





	// • === value → ... »
	private static function value($value)
	{
		$html = '<span style="' . self::style('content') . '">';

		switch (true) {
			case is_string($value) || is_numeric($value):
				return $html . $value . '</span>';

			case is_bool($value):
				return $html . ($value ? 'True' : 'False') . '</span>';

			case is_null($value):
				return $html . 'Null</span>';

			case is_array($value):
				return self::array($value);

			case is_callable($value):
				return $html . 'Closure</span>';

			default:
				return $html . '</span>';
		}
	}






	// • === null → ... »
	private static function null($var)
	{
		return self::value($var);
	}





	// • === object → ... »
	private static function object(object $var): string
	{
		$color = self::style('key');
		$output = '<em style="' . self::style('label') . '">is_object</em>';
		$output .= '<div style="' . self::style('partition') . '">';

		foreach ($var as $key => $value) {
			$output .= sprintf(
				'<div><strong style="%s">%s → </strong>%s</div>',
				$color,
				$key,
				self::value($value)
			);
		}

		return $output . '</div>';
	}





	// • === array → ... »
	protected static function array(array $var): string
	{
		$color = self::style('key');
		$output = '<em style="' . self::style('label') . '">is_array</em>';
		$output .= '<div style="' . self::style('partition') . '">';

		foreach ($var as $key => $value) {
			$output .= sprintf(
				'<div><strong style="%s">%s: </strong>%s</div>',
				$color,
				$key,
				self::value($value)
			);
		}

		return $output . '</div>';
	}





	// • === boolean → ... »
	protected static function boolean(bool $var)
	{
		return '<strong style="' . self::style('key') . '">Boolean: </strong>' . self::value($var);
	}





	// • === string → ... »
	protected static function string(string $var)
	{
		return self::value($var);
	}





	// • === debug → ... »
	public static function debug($var, string $title = null): void
	{
		$output = '<div style="' . self::style('container') . '">';

		if ($title) {
			$output .= '<strong style="' . self::style('title') . '">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</strong> ';
		}

		$output .= match (true) {
			is_null($var) => self::null($var),
			is_string($var), is_integer($var), is_numeric($var) => self::string($var),
			is_bool($var) => self::boolean($var),
			is_array($var) => self::array($var),
			is_object($var) => self::object($var),
			default => 'Unsupported type'
		};

		echo $output . '</div>';
	}





	// • === exit → output and exit »
	public static function exit($var, string $title = self::BRAND): void
	{
		self::debug($var, $title);
		exit;
	}





	// • === print → ... »
	public static function print($var)
	{
		return self::debug([self::ABBR => $var]);
	}





	// • === trace → ... »
	public static function trace($file, $line)
	{
		return ['file' => $file, 'line' => $line];
	}





	// • === label → ensure the label includes the 'YAIC™' branding »
	protected static function label($label)
	{
		if (strpos($label, self::ABBR) === false) {
			$label = self::BRAND . ' • ' . $label;
		}
		return $label;
	}






	// • === oversight → ... »
	public static function oversight($label, $message, $extra = null, $trace = null)
	{
		$label = self::label($label);

		// + initialize the error message
		$error = '<strong>' . ucwords($label) . '</strong> | ' . $message;

		// + process the extra information
		if (!empty($extra)) {
			if (is_array($extra)) {
				$extra = count(array_filter(array_keys($extra), 'is_numeric')) === count($extra)
					? implode(' • ', $extra)
					: implode(
						' • ',
						array_map(
							fn($key, $val) => $key . ': ' . (is_callable($val) ? self::closure($val) : $val),
							array_keys($extra),
							$extra
						)
					);
			}

			// + append the extra information to the error message
			if (is_string($extra) || is_numeric($extra)) {
				$error .= ' → [<em>' . htmlspecialchars($extra, ENT_QUOTES, 'UTF-8') . '</em>]';
			}
		}

		// + append trace information if provided
		if (!empty($trace)) {
			$error .= sprintf(
				' <br><span style="color: red;"> {%s:%d}</span>',
				htmlspecialchars($trace['file'], ENT_QUOTES, 'UTF-8'),
				(int) $trace['line']
			);
		}

		// » output the error message & exit
		return self::exit($error);
	}





	// • === caller → report class/function unavailable »
	public static function caller($caller, $type, &$file = null)
	{
		if ($type === 'CLASS' && !class_exists($caller) || $type === 'FUNCTION' && !function_exists($caller)) {
			return self::oversight($caller, ucfirst(strtolower($type)) . ' Unavailable!', $file);
		}
		return true;
	}





	// • === run → ... »
	public static function run($var)
	{
		echo '<pre>' . var_export($var, true) . '</pre>' . "\n\r";
	}





	// • === dump → ... »
	public static function dump($var)
	{
		return var_dump($var);
	}

}//> end of Yaic