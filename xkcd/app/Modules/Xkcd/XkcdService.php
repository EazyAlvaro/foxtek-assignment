<?php

namespace App\Modules\Xkcd;

use App\Modules\Core\ContentRepository;
use Carbon\Carbon;
use GuzzleHttp;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class XkcdService
{
	private $target = 'https://xkcd.com/{id}/info.0.json';

	/**
	 * the requirement spec said: "Do not abuse the API's!
	 * Those are publicly accessible resources,
	 * you don't want to overload them by firing thousands of requests each time.
	 * Hint: this applies especially for XKCD comics API."
	 *
	 * Ideally, one would run this import ONCE for a big import,
	 * and once daily to check for single updates, so this falls within spec ;)
	 *
	 * Since there are 2165 comics at the time of coding this, it should take
	 * about 4 minutes to import them ALL from scratch
	 */
	public function import()
	{
		$done = false;

		$last = ContentRepository::getLatest('xkcd');
		$nextId = $last ? $last->number + 1 : 1;

		do {
			try {
				$data = $this->getData($nextId);

				$record = [
					'source' => 'xkcd',
					'year' => $data['year'],
					'number' => $data['num'],
					'date' => Carbon::createFromDate($data['year'], $data['month'], $data['day']),
					'name' => $data['safe_title'],
					'link' => $data['img'],
					'details' => $data['alt']
				];

				ContentRepository::insert($record);
				$nextId++;
			} catch (NotFoundHttpException $notFound) {
				// either the api changed, or there is nothing more to get
				$done = true;
			} catch (GuzzleHttp\Exception\ClientException $ex) {
				// same as above
				$done = true;
			}

		} while (!$done);
	}

	private function getData(int $id)
	{
		$newUrl = str_replace('{id}', $id, $this->target);

		$client = new GuzzleHttp\Client();
		$res = $client->request('GET', $newUrl, []);

		if ($res->getStatusCode() == 404) {
			throw new NotFoundHttpException();
		}

		return json_decode($res->getBody(), true);
	}
}