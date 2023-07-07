<?php

namespace App\Http\Controllers;

use App\Services\CostCompany;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * Show the list of companies
     * Travel cost of a particular company is the total travel price of employees in that company and its child companies
     *
     * @return JsonResponse
     */
    public function all(CostCompany $service): JsonResponse
    {

        return response()->json($service->getList());
    }
}
