<?php

namespace App\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
    	'source',
		'year',
		'number',
		'date',
		'name',
		'link',
		'details'
	];

    protected $hidden = [
    	'created_at',
		'updated_at',
		'id',
		'year',
		'source'
	];

    protected $casts = [
    	'date' => 'date:Y-m-d'
	];
}
