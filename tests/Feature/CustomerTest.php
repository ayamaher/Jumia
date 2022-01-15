<?php

namespace Tests\Feature;

use Tests\APITest;

class CustomerTest extends APITest
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListAllNumbers()
    {
        $this->disableExceptionHandling();
        $response = $this->json('get', 'api/customers');
        $phoneNumbers = $response->json();
        foreach ($phoneNumbers as $phoneNumber) {
            $this->assertArrayHasKey('phone', $phoneNumber);
            $this->assertArrayHasKey('country', $phoneNumber);
            $this->assertArrayHasKey('code', $phoneNumber);
            $this->assertArrayHasKey('state', $phoneNumber);

        }

        $response->assertStatus(200);
        $this->assertCount(41, $phoneNumbers);
    }

    public function testListAllCountryNumbers()
    {
        $this->disableExceptionHandling();
        $response = $this->json('get', 'api/customers?country=Ethiopia');
        $phoneNumbers = $response->json();

        foreach ($phoneNumbers as $phoneNumber) {
            $this->assertArrayHasKey('phone', $phoneNumber);
            $this->assertArrayHasKey('country', $phoneNumber);
            $this->assertArrayHasKey('code', $phoneNumber);
            $this->assertArrayHasKey('state', $phoneNumber);
            $this->assertEquals('Ethiopia', $phoneNumber['country']);
        }
        $response->assertStatus(200);
        $this->assertCount(9, $phoneNumbers);
    }

    public function testListAllCountryValidNumbers()
    {
        $this->disableExceptionHandling();
        $response = $this->json('get', 'api/customers?country=Ethiopia&state=OK');
        $phoneNumbers = $response->json();

        $this->assertPhoneNumbers($phoneNumbers, 'OK');
        $response->assertStatus(200);
        $this->assertCount(7, $phoneNumbers);
    }

    public function testListAllCountryInvalidNumbers()
    {
        $this->disableExceptionHandling();
        $response = $this->json('get', 'api/customers?country=Ethiopia&state=NOK');
        $phoneNumbers = $response->json();

        $this->assertPhoneNumbers($phoneNumbers, 'NOK');
        $response->assertStatus(200);
        $this->assertCount(2, $phoneNumbers);
    }

    /**
     * @param $phoneNumbers
     */
    public function assertPhoneNumbers($phoneNumbers, $state): void
    {
        foreach ($phoneNumbers as $phoneNumber) {
            $this->assertArrayHasKey('phone', $phoneNumber);
            $this->assertArrayHasKey('country', $phoneNumber);
            $this->assertArrayHasKey('code', $phoneNumber);
            $this->assertArrayHasKey('state', $phoneNumber);
            $this->assertEquals('Ethiopia', $phoneNumber['country']);
            $this->assertEquals($state, $phoneNumber['state']);

        }
    }
}
