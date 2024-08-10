<?php //*** Model » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Facil\Concept\Trait;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

trait Model
{

	// • constants
	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	const DELETED_AT = 'deleted';





	// • property
	protected $dates = ['deleted'];




	// • === hasColumn → ... » []
	public function hasColumn(string $column)
	{
		return Schema::hasColumn($this->getTable(), $column);
	}





	// • === hasValue → ... » []
	public function hasValue(string $column, $value = null)
	{
		if (is_null($value)) {
			return isset($this->$column);
		} else {
			return isset($this->$column) && ($this->$column == $value);
		}
	}





	// • === lastRow → ... » []
	public function lastRow($withTrashed = true)
	{
		if (!$withTrashed) {
			return parent::latest()->first();
		}
		return parent::withTrashed()->latest()->first();
	}





	// • === lastID → ... » []
	public function lastID($id = 'id', $withTrashed = true)
	{
		$record = $this->lastRow($withTrashed);
		if (isset($record->{$id})) {
			return $record->{$id};
		}
		return null;
	}





	// • === lastSN → ... » []
	public function lastSN($column = 'guid', $withTrashed = true)
	{
		$record = $this->lastRow($withTrashed);
		if (isset($record->{$column})) {
			return $record->{$column};
		}
		return null;
	}





	// • === findBy → ... » []
	public static function findBy(string $field, $value, $column = null)
	{
		if (is_array($column)) {
			$record = parent::select($column)->where($field, $value)->first();
		} else {
			$record = parent::where($field, $value)->first();
			if ($record && $column && is_string($column) && isset($record->$column)) {
				$record = $record->$column;
			}
		}
		return $record ?? null;
	}





	// • === findID → ... » []
	public static function findID($id, $column = null)
	{
		$record = self::find($id);
		return $record;
	}





	// • === findGuid → ... » []
	public static function findGuid($puid, $column = null, $field = 'guid')
	{
		return self::findBy($field, $puid, $column);
	}





	// • === findPuid → ... » []
	public static function findPuid($puid, $column = null, $field = 'puid')
	{
		return self::findBy($field, $puid, $column);
	}





	// • === findSuid → ... » []
	public static function findSuid($puid, $column = null, $field = 'suid')
	{
		return self::findBy($field, $puid, $column);
	}





	// • === findTuid → ... » []
	public static function findTuid($puid, $column = null, $field = 'tuid')
	{
		return self::findBy($field, $puid, $column);
	}





	// • === findAuthor → ... » []
	public static function findAuthor($puid, $column = null, $field = 'author')
	{
		return self::findBy($field, $puid, $column);
	}





	// • === create → ... » [instance with data ($data->field) & false]
	public static function create($data)
	{
		try {
			return parent::create($data);
		} catch (QueryException $e) {
			// TODO: Log error & handle exception | Move to a handler class
			Log::error('Error::DB->Create: ' . $e->getMessage());
			return false;
		}
	}

}//> end of Model