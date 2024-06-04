<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user());
    }

public function update(Request $request)
{
    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|string|max:15|unique:users',
        'address' => 'required|string|max:255',
        'image' => 'image|mimes:jpeg,png,jpg,gif',
        'country_id' => 'required|exists:countries,id',
    ]);

    try {
        $user = auth()->user();
        $user->full_name = $validated['full_name'];
        $user->email = $validated['email'];
        $user->mobile = $validated['mobile'];
        $user->address = $validated['address'];
        $user->country_id = $validated['country_id'];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->storeAs('public/images', $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return response()->json(['user' => $user], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to update user.'], 500);
    }
}

}
