<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function patch_settings()
    {
        $data = [
            "key" => "overtime_method",
            "value" => "1"
        ];
        $response = $this->patch('/api/settings', $data);

        $response->assertStatus(202);
    }
}
