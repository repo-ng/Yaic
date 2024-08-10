<?php //*** HandleX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Spry;

use App\Yaic\Spry\Data\StringX;
use Illuminate\Database\QueryException;


class HandleX
{

	// • === response → ... » []
	protected static function response($response){
		if(is_array($response)){
			if(isset($response['error']) && $response['error'] === true){

			}
		}
	}





	// • === eloquent → ... » []
	public static function eloquent(callable $callback)
	{
		try {
			return $callback();
		} catch (QueryException $e) {
			if (($violation = self::isDuplicate($e)) !== false) {
				// return response()->json(['error' => 'Duplicate record found.'], 422);
				return self::response($violation);
			}
			throw $e;
		}
	}





	// • === isDuplicate → ... » []
	private static function isDuplicate(QueryException $e)
	{
		// if($e->getCode() === '23000' || $e->errorInfo[1] === 1062){
		if ($e->errorInfo[1] === 1062) {
			$message = $e->errorInfo[2];
			$matches = [];
			preg_match('/Duplicate entry \'(.+?)\' for key/', $message, $matches);
			if (isset($matches[1])) {
				$value = $matches[1];
				$column = StringX::after($message, 'key');
				$column = StringX::crop($column, "'");
				$column = StringX::cropEnd($column, '_unique');
				$column = StringX::after($column, '.');
				$column = StringX::afterAs($column, '_');
				$duplicate = [$column => $value];

				if (!empty($duplicate)) {
					$error = [
						'error' => true,
						'type' => 'duplicate',
						'data' => $duplicate,
						'summary' => 'Oops, duplicate ' . strtolower($column) . ' (' . strtolower(Str($value)->words(3)) . ')!',
						'message' => ucfirst($column) . 'exists',
						'log' => $message
					];
					return $error;
				}
			}

		}
		return false;
	}

}//> end of HandleX