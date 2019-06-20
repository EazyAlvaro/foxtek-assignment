<?php

namespace App\Modules\Space;

use App\Modules\Core\ContentRepository;
use Carbon\Carbon;
use GuzzleHttp;

class SpaceService
{
	private $target = 'https://api.spacexdata.com/v2/launches';

	public function import()
	{
		$collection = collect($this->getData());

		$collection = $collection->map(function (array $record) {
			$record = [
				'source' => 'space',
				'year' => $record['launch_year'],
				'number' => $record['flight_number'],
				'date' => Carbon::createFromTimestamp((int)$record['launch_date_unix']),
				'name' => $record['mission_name'],
				'link' => $record['links']['article_link'],
				'details' => $record['details'] ?? '' // there are 7 records in the source with this field empty
			];
			return $record;
		});

		ContentRepository::insertMany($collection);
	}

	private function getData()
	{
		// Statuscode checking intentionally omitted, this is demo code

		$client = new GuzzleHttp\Client();
		$res = $client->request('GET', $this->target, []);
		return json_decode($res->getBody(), true);
	}

}