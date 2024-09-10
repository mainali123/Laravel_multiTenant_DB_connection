<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function register_company(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'domain' => 'required',
        ]);

        $company = new Company();
        $company_valid = $company->create_company($validatedData);

        return response()->json($company_valid);
    }

    public function company_selected_user(Request $request)
    {
        $validatedData = $request->validate([
            'company' => 'required|numeric',
        ]);

        $company = new Company();
        return $company->select_company_db($validatedData);
    }
}
