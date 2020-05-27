<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersCdu
 * 
 * @property int $id
 * @property string $username
 * @property string $pic
 * @property string $email
 * @property string $code
 * @property string $phone
 * @property bool $active
 * 
 * @property Collection|Condonation[] $condonations
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class UsersCdu extends Model
{
	protected $table = 'users_cdu';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'active' => 'bool'
	];

	protected $fillable = [
		'username',
		'email',
		'phone',
		'active',
		'pic',
		'code'
	];

	public function condonations()
	{
		return $this->hasMany(Condonation::class, 'id_userCDU');
	}

	public function payments()
	{
		return $this->hasMany(Payment::class, 'id_userCDU');
	}
}
