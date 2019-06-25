<?php namespace Backpack\Settings\app\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Setting extends Model {

	use CrudTrait;

	protected $table = 'settings';
	protected $fillable = ['value'];

}
