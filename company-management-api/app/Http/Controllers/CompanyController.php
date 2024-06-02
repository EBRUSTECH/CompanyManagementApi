<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Auth::user()->companies;
        return response()->json($companies);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|string|email|max:255|unique:companies',
            'country_id' => 'required|exists:countries,id',
        ]);

        $company = Auth::user()->companies()->create($validated);

        return response()->json(['company' => $company], 201);
    }

    public function update(Request $request, Company $company)
    {
        if ($company->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|string|email|max:255|unique:companies,company_email,' . $company->id,
            'country_id' => 'required|exists:countries,id',
        ]);

        $company->update($validated);

        return response()->json(['company' => $company]);
    }

    public function destroy(Company $company)
    {
        if ($company->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $companies = Auth::user()->companies()
            ->where('company_name', 'like', '%' . $query . '%')
            ->get();

        return response()->json($companies);
    }

    public function publicIndex()
    {
        $companies = Company::with('services')->get();
        return response()->json($companies);
    }
}
