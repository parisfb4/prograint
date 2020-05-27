<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DataType
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $display_name_singular
 * @property string $display_name_plural
 * @property string $icon
 * @property string $model_name
 * @property string $policy_name
 * @property string $controller
 * @property string $description
 * @property bool $generate_permissions
 * @property int $server_side
 * @property string $details
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|DataRow[] $data_rows
 *
 * @package App\Models
 */
class DataType extends Model
{
	protected $table = 'data_types';

	protected $casts = [
		'generate_permissions' => 'bool',
		'server_side' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'display_name_singular',
		'display_name_plural',
		'icon',
		'model_name',
		'policy_name',
		'controller',
		'description',
		'generate_permissions',
		'server_side',
		'details'
	];

	public function data_rows()
	{
		return $this->hasMany(DataRow::class);
	}
}
