<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Area
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Discipline[] $disciplines
 *
 * @package App\Models
 */
class Area extends Model
{
	protected $table = 'areas';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function disciplines()
	{
		return $this->hasMany(Discipline::class, 'id_area');
	}
}
