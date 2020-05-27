<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Concept
 * 
 * @property int $id
 * @property string $concept
 * @property string $reference
 * @property string $agreement
 * @property float $cost
 * @property string $clabe
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Concept extends Model
{
	protected $table = 'concepts';

	protected $casts = [
		'cost' => 'float'
	];

	protected $fillable = [
		'concept',
		'reference',
		'agreement',
		'cost',
		'clabe'
	];
}
