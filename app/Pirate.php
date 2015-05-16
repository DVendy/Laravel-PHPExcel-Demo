<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Pirate extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pirate';

	protected $fillable = ['name', 'bounty'];
}
