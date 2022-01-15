<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepo;

class mainService
{

    public $customerRepo;

    public function __construct(CustomerRepo $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public $countries = [
        [
            "name" => "Cameroon",
            "code" => "+237",
            "regex" => "/\(237\)\ ?[2368]\d{7,8}$/",
            "codeRegex" => "(237) ",
        ],
        [
            "name" => "Ethiopia",
            "code" => "+251",
            "regex" => "/\(251\)\ ?[1-59]\d{8}$/",
            "codeRegex" => "(251) ",
        ],
        [
            "name" => "Morocco",
            "code" => "+212",
            "regex" => "/\(212\)\ ?[5-9]\d{8}$/",
            "codeRegex" => "(212) ",
        ],
        [
            "name" => "Mozambique",
            "code" => "+258",
            "regex" => "/\(258\)\ ?[28]\d{7,8}$/",
            "codeRegex" => "(258) ",
        ],
        [
            "name" => "Uganda",
            "code" => "+256",
            "regex" => "/\(256\)\ ?\d{9}$/",
            "codeRegex" => "(256) ",
        ],
    ];

    public function getCustomersWithCountries(string $country = "ALL", string $state = "ALL"): array
    {
        $phoneNumbers = [];
        $customers = Customer::All()->toArray();
        $countries = $this->countries;
        foreach ($customers as $key => $customer) {
            $phoneNumbers[$key]['phone'] = $customer['phone'];
            foreach ($countries as $country) {
                if (str_contains($customer['phone'], preg_replace('/\+/', '', $country['countryCode']))) {
                    $phoneNumbers[$key]['country'] = $country['name'];
                    $phoneNumbers[$key]['code'] = $country['code`'];
                    $countryRegex = '/' . $country['regex'] . '/';
                    (preg_match($countryRegex, $customer['phone'])) ? $phoneNumbers[$key]['state'] = "OK" : $phoneNumbers[$key]['state'] = "NOK";
                }
            }
        }
        return $phoneNumbers;
    }

    public function getCountry($countryName)
    {
        return ($countryName != "ALL") ? collect($this->countries)->filter(function ($country) use ($countryName) {
            return $country['name'] == $countryName;
        })->first() : NULL;
    }

    public function getPhoneNumbers(string $country, string $state)
    {
        $countryObj = $this->getCountry($country);
        return $this->customerRepo->getPhoneNumbers($countryObj, $state, $this->countries)->toArray();
    }
}
