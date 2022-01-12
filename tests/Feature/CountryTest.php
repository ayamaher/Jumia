<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\APITest;
use Tests\TestCase;

class CountryTest extends APITest
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListAllCountries()
    {
        $response = $this->json('get', 'api/countries');
        $countries = $response->json();

        $response->assertOk();
        $this->assertCount(5, $countries);
        foreach ($countries as $country) {
            $this->assertArrayHasKey('name', $country);
            $this->assertArrayHasKey('code', $country);
            $this->assertArrayHasKey('regex', $country);
            $this->assertArrayHasKey('codeRegex', $country);

        }
    }
}
