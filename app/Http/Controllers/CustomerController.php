<?php

namespace App\Http\Controllers;

use App\Services\mainService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $mainService;

    public function __construct(mainService $mainService)
    {
        $this->mainService = $mainService;
    }


    public function index(Request $request): array
    {
        logger()->info('query : ', [$request->query->get('country')]);

        $country = $request->query->get('country') ? $request->query->get('country') : "ALL";
        $state = $request->query->get('state') ? $request->query->get('state') : "ALL";

        logger()->info('country and state : ', [$country, $state]);

        return $this->mainService->getCustomersWithCountries($country, $state);
    }

    public function phoneNumbers(Request $request): array
    {
        $country = $request->query->get('country') ? $request->query->get('country') : "ALL";
        $state = $request->query->get('state') ? $request->query->get('state') : "ALL";

        return $this->mainService->getPhoneNumbers($country, $state);
    }
}
