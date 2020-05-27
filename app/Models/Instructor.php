<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Instructor
 * 
 * @property int $id
 * @property string $name
 * @property string $mail
 * @property string $phone
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Schedule[] $schedules
 *
 * @package App\Models
 */
class Instructor extends Model
{
	protected $table = 'instructors';

	protected $fillable = [
		'name',
		'mail',
		'phone'
	];

	public function schedules()
	{
		return $this->hasMany(Schedule::class, 'id_instructor');
	}
}
