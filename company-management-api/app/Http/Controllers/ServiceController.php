<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
        ]);

        $company = Auth::user()->companies()->findOrFail($validated['company_id']);

        $service = $company->services()->create($validated);

        return response()->json(['service' => $service], 201);
    }

    public function update(Request $request, Service $service)
    {
        if ($service->company->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $service->update($validated);

        return response()->json(['service' => $service]);
    }

    public function destroy(Service $service)
    {
        if ($service->company->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully']);
    }
}

