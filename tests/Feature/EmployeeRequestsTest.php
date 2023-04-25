<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeRequestsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_main_api_request()
    {
        $response = $this->get('/api');

        $response->assertStatus(404);
    }

    public function test_store_employee_request()
    {
        $payload = [
            'name' => $this->faker->name
        ];

        $response = $this->post("/api/employee", $payload);

        $response->assertStatus(200);

        $getUser = $this->post("/api/employee");

        $decodeEmployeeId = json_decode($getUser->getContent())->id;

        if($decodeEmployeeId) {
            $payload = [
                'start_date' => now(),
                'end_date' => now()->addDays(5),
                'country' => 'PL'
            ];

            $response = $this->post("/api/employee/{$decodeEmployeeId}/delegation", $payload);

            $response->assertStatus(200);
        }
    }

}
