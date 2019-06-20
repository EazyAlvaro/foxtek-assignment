<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Core\ContentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
	/**
	 * @param Request $request
	 * @param string  $source xkcd|space
	 * @param int     $year 2026, 2019, etc
	 * @param int     $limit maximum records to show
	 *
	 * @return JsonResponse
	 */
	public function show(Request $request, string $source, int $year, int $limit)
	{
		$response = $this->buildResponse($source, $year, $limit);
		return new JsonResponse($response);
	}

	/**
	 * Build the response according to the assignment specification
	 */
	private function buildResponse(string $source, int $year, int $limit): array
	{
		$data = ContentRepository::get($source, $year, $limit);

		return [
			'meta' => [
				'request' => [
					'sourceId' => $source,
					'year' => $year,
					'limit' => $limit
				]
			],
			'timestamp' => now(), // lucky me, by default it returns the timezone according to spec
			'data' => $data,
		];
	}
}