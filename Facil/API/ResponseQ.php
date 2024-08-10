<?php //*** ResponseQ » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Facil\API;

use Illuminate\Support\Facades\Route;


class ResponseQ
{

	// • property
	private static $init;
	private static $response;





	// • === init → ... » []
	private static function init()
	{
		if (!self::$init) {
			$route = Route::current();
			if ($route) {
				$uri = $route->uri(); // $title = $route->getName();
			} else {
				$uri = app('request')->path();
			}

			$title = "Request Complete";
			self::$response = [
				'status' => 'completed', # [unknown|error|failure|success]
				'version' => "OREO",
				'terminus' => '/' . $uri,
				'response' => [
					'code' => 'C204SE',
					'title' => ucwords($title),
					'message' => "Sorry, no message returned for completed request",
					'count' => 0,
					'data' => []
				]
			];
			self::$init = true;
		}
	}





	// • === merge → ... » []
	private static function merge(array $response = null)
	{
		self::init();
		if ($response && is_array($response)) {
			if (isset(self::$response['response']) && isset($response['response'])) {
				self::$response['response'] = array_merge(self::$response['response'], $response['response']);
				unset($response['response']);
			}
			if (!empty($response)) {
				self::$response = array_merge(self::$response, $response);
			}
			return true;
		}
		return false;
	}





	// • === precondition → ... » []
	public static function precondition(string $message = null, string $title = 'Precondition Ignored', array|string|null $error = [])
	{
		if (!$message) {
			$message = "Oh!, required conditions ignored";
		}
		$response['status'] = 'error';
		$response['response']['message'] = $message;
		$response['response']['code'] = 'C428IE';
		if (!empty($title)) {
			$response['response']['title'] = $title;
		}

		if (!empty($error)) {
			$response['response']['error'] = $error;
		}
		self::merge($response);
	}





	// • === param → ... » []
	public static function param(string $message = null, string $title = 'Parameter Required', $error = null)
	{
		self::precondition($message, $title, $error);
	}





	// • === invalid → ... » []
	public static function invalid(string $message = null, string $title = 'Value Incorrect', array $error = [])
	{
		if (empty($message)) {
			$message = "Oh!, incorrect parameter value provided.";
		}
		$response['status'] = 'error';
		$response['response']['message'] = $message;
		$response['response']['code'] = 'C498IE';
		if (!empty($title)) {
			$response['response']['title'] = $title;
		}
		self::merge($response);
	}





	// • === hint → ... » []
	public static function hint(string $hint = null)
	{
		if ($hint) {
			$resp['response']['hint'] = $hint;
		}
		self::merge($resp);

		if (!empty(self::$response['response']['hint'])) {
			return self::$response['response']['hint'];
		}
		return false;
	}





	// • === code → ... » []
	public static function code()
	{
		self::init();
		$code = false;
		$resp = self::$response;
		if (!empty($resp['response']['code'])) {
			$code = $resp['response']['code'];
		}

		if (!empty($code) && is_string($code) && strlen($code) > 5) {
			$code = substr($code, 1);
			$code = substr($code, 0, -2);
		}
		if ($code === '204') { // for no content
			$code = '202';
		}
		if (empty($code)) {
			$code = '200';
		}
		return (int) $code;
	}





	// • === response → ... » []
	public static function response()
	{
		self::init();
		return self::$response;
	}





	// • === json → ... » []
	public static function json($response = null, $code = null)
	{
		$code = $code ?? self::code();
		$response = $response ?? self::response();
		return response()->json($response, $code);
	}





	// • === requireKey → ... » []
	public static function requireKey()
	{
		self::param('Oh!, access key is required', 'Key Required');
		self::hint('Include access key parameter within headers');
		return self::json();
	}





	// • === invalidKey → ... » []
	public static function invalidKey($title = 'Invalid Key')
	{
		self::invalid('Oh!, invalid key provided', $title);
		self::hint('Provide a valid key within headers');
		return self::json();
	}

}//> end of ResponseQ