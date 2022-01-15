<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepo extends Repository
{
    protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function getPhoneNumbers($countryObj, $state, $countries)
    {
        if (isset($countryObj)) {
            $result = $this->model->select([$countryObj['code'] . ' as code', $countryObj['name'] . ' as country', 'phone'])->where('phone', 'like', $countryObj['codeRegex'] . '%')->get();
            $result = $result->map(function ($customer) use ($countryObj) {
                $customer->state = (preg_match($countryObj['regex'], $customer['phone'])) ? "OK" : "NOK";
                $customer->phone = str_replace($countryObj['codeRegex'], '', $customer->phone);
                return $customer;
            });
            if ($state !== "ALL")
                $result = $result->where('state', '=', $state);
        } else {
            $result = $this->model->select(['phone'])->get();
            $result = $result->map(function ($customer) use ($countries) {
                foreach ($countries as $country) {
                    if (str_starts_with($customer['phone'], $country['codeRegex'])) {
                        $customer->country = $country['name'];
                        $customer->code = $country['code'];
                        (preg_match($country['regex'], $customer['phone'])) ? $customer->state = "OK" : $customer->state = "NOK";
                    }
                };
                $customer->phone =  strstr($customer->phone, ') ', false);
                return $customer;
            });
        }
        return $result;
    }
}
