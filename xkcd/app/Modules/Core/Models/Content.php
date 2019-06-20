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

    protected $casts = [
    	'date' => 'date'
	];
}
