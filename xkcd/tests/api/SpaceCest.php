<?php

use Codeception\Util\Shared\Asserts;

class SpaceCest
{
	use Asserts;

	/**
	 * I only provided this one test to verify that the api has the desired structure.
	 * (And show that i know how to write tests, of course.)
	 *
	 * It tests the first case provided in the assignment, and checks for:
	 *    1) meta content
	 *    2) amount of data records
	 *    3) exact content of the first returned record
	 */
	public function firstSpecTestCase(ApiTester $I)
	{
		# Arrange
		$I->sendGET('/space/year/2013/limit/2');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseContains('{"meta":{"request":{"sourceId":"space","year":2013,"limit":2}}');

		# Act
		$data = $I->grabDataFromResponseByJsonPath('$..data');
		$this->assertEquals(2, count($data[0]), 'there should be 2 records matching that request');
		$firstRecord = $data[0][0];

		# Assert
		$this->assertEquals([
			'number' => 10,
			'date' => '2013-03-01',
			'link' => "https://en.wikipedia.org/wiki/SpaceX_CRS-2",
			'name' => 'CRS-2',
			'details' => "Last launch of the original Falcon 9 v1.0 launch vehicle"

		], $firstRecord,
			"We expect to see the first of these records exactly according to the assignment"
		);
	}
}
