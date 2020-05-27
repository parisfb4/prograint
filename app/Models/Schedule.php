<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 * 
 * @property int $id
 * @property int $id_course
 * @property int $id_instructor
 * @property string $m
 * @property string $t
 * @property string $w
 * @property string $r
 * @property string $f
 * @property string $s
 * @property int $capacity
 * 
 * @property Course $course
 * @property Instructor $instructor
 *
 * @package App\Models
 */
class Schedule extends Model
{
	protected $table = 'schedules';
	public $timestamps = false;

	protected $casts = [
		'id_course' => 'int',
		'id_instructor' => 'int',
		'capacity' => 'int'
	];

	protected $fillable = [
		'id_course',
		'id_instructor',
		'm',
		't',
		'w',
		'r',
		'f',
		's',
		'capacity'
	];

	public function course()
	{
		return $this->belongsTo(Course::class, 'id_course');
	}

	public function instructor()
	{
		return $this->belongsTo(Instructor::class, 'id_instructor');
	}
}
