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
		$collection->each(function (array $record) {
			Content::firstOrCreate(
				[
					'source' => $record['source'],
					'number' => $record['number']
				],
				$record
			);
		});
	}

	/**
	 * Fetch Content records by the listed params, ordered ASC by number
	 *
	 * @param $source
	 * @param $year
	 * @param $limit
	 *
	 * @return Collection
	 */
	public static function get($source, $year, $limit): Collection
	{
		return Content::where([
			'source' => $source,
			'year' => $year
		])->orderBy('number', 'asc')
			->take($limit)
			->get();
	}
}