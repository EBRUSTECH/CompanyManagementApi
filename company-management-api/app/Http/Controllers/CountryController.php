<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function listCountries()
    {
        $countries = Country::all();

        // dd($countries);

        if ($countries->isEmpty()) {
            return response()->json([
                'message' => 'No country found'
            ], 404);
        }

        return response()->json($countries);
    }

}
