<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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

        // Since the middleware handles database switching, just return success
        $currentDatabase = DB::connection()->getDatabaseName();

        if ($currentDatabase) {
            return response()->json(['success' => true, 'message' => 'Company selected successfully', 'database' => $currentDatabase]);
        } else {
            return response()->json(['success' => false, 'message' => 'Company not found']);
        }
    }
}
