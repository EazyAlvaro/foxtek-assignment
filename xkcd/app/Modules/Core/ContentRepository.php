<?php

namespace App\Modules\Core;

use Illuminate\Support\Collection;
use App\Modules\Core\Models\Content;

class ContentRepository
{

	/**
	 * Inserts Content records and tries to keep them unique
	 *
	 * @param Collection $collection
	 */
	public static function insertMany(Collection $collection)
	{
		$collection->each(function(array $record){
			Content::firstOrCreate(
				[
					'source' => $record['source'],
					'number' => $record['number']
				],
				$record
			);
		});
	}
}