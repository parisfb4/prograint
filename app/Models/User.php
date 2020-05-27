<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property int $id
 * @property int $role_id
 * @property string $name
 * @property string $email
 * @property string $avatar
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string $settings
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Role $role
 * @property Collection|Role[] $roles
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'role_id' => 'int'
	];

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'role_id',
		'name',
		'email',
		'avatar',
		'email_verified_at',
		'password',
		'remember_token',
		'settings'
	];

    public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'user_roles');
	}
}
