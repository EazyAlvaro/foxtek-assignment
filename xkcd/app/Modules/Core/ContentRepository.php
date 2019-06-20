<?php

namespace App\Modules\Core;

use Illuminate\Support\Collection;
use App\Modules\Core\Models\Content;

class ContentRepository
{

	/**
	 * Inserts Content records and tries to keep them unique (by number)
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
	 * inserts a single Content record, provided it is unique (by number)
	 */
	public static function insert(array $record)
	{
		Content::firstOrCreate(
			[
				'source' => $record['source'],
				'number' => $record['number']
			],
			$record
		);
	}


	public static function getLatest(string $source): ?Content
	{
		return Content::where([
			'source' => $source,
		])->orderBy('number', 'desc')
			->take(1)
			->get()
			->first();
	}

	/**
	 * Fetch Content records by the listed params, ordered ASC by number
	 */
	public static function get(string $source, int $year, int $limit): Collection
	{
		return Content::where([
			'source' => $source,
			'year' => $year
		])->orderBy('number', 'asc')
			->take($limit)
			->get();
	}
}