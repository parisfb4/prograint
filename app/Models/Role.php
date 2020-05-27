<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Permission[] $permissions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'roles';

	protected $fillable = [
		'name',
		'display_name'
	];

	public function permissions()
	{
		return $this->belongsToMany(Permission::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
