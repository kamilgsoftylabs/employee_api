<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeRequestsTest extends TestCase
{
	use RefreshDatabase, WithFaker;

	public function testMainApiRequest()
	{
		$response = $this->get('/api');

		$response->assertStatus(404);
	}

	public function testStoreEmployeeAndDelegationRequest()
	{
		$payload = [
			'name' => $this->faker->name,
		];

		$response = $this->post('/api/employee', $payload);

		$response->assertStatus(200);

		$getEmployee = $this->post('/api/employee');

		$decodeEmployeeId = json_decode($getEmployee->getContent())->id;

		if ($decodeEmployeeId) {
			$payload = [
				'start_date' => now(),
				'end_date'   => now()->addDays(5),
				'country'    => 'PL',
			];

			$response = $this->post("/api/employee/{$decodeEmployeeId}/delegation", $payload);

			$response->assertStatus(200);
		}
	}
}
