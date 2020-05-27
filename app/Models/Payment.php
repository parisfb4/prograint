<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property int $id
 * @property int $id_userCDU
 * @property string $reference
 * @property string $comments
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property UsersCdu $users_cdu
 *
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payments';

	protected $casts = [
		'id_userCDU' => 'int'
	];

	protected $fillable = [
		'id_userCDU',
		'reference',
		'comments'
	];

	public function users_cdu()
	{
		return $this->belongsTo(UsersCdu::class, 'id_userCDU');
	}
}
