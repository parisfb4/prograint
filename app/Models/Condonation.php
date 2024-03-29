<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Condonation
 * 
 * @property int $id
 * @property int $id_userCDU
 * @property string $comments
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property UsersCdu $users_cdu
 *
 * @package App\Models
 */
class Condonation extends Model
{
	protected $table = 'condonations';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'id_userCDU' => 'int'
	];

	protected $fillable = [
		'id_userCDU',
		'comments'
	];

	public function users_cdu()
	{
		return $this->belongsTo(UsersCdu::class, 'id_userCDU');
	}
}
