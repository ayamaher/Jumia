<?php

namespace App\Http\Controllers;

use App\Services\mainService;

class CountryController extends Controller
{
    private $mainService;

    public function __construct(mainService $mainService)
    {
        $this->mainService = $mainService;
    }

    public function index(): array
    {
        return $this->mainService->countries;
    }
}
