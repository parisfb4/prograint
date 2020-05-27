<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Discipline
 * 
 * @property int $id
 * @property string $name
 * @property int $id_area
 * 
 * @property Area $area
 * @property Collection|Course[] $courses
 * @property Collection|Level[] $levels
 *
 * @package App\Models
 */
class Discipline extends Model
{
	protected $table = 'disciplines';
	public $timestamps = false;

	protected $casts = [
		'id_area' => 'int'
	];

	protected $fillable = [
		'name',
		'id_area'
	];

	public function area()
	{
		return $this->belongsTo(Area::class, 'id_area');
	}

	public function courses()
	{
		return $this->hasMany(Course::class, 'id_discipline');
	}

	public function levels()
	{
		return $this->hasMany(Level::class, 'id_discipline');
	}
}
