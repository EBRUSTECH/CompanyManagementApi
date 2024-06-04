<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
     public function listCountries()
    {
        $countries = Country::all();

         //dd($countries);

        if ($countries->isEmpty()) {
            return response()->json([
                'message' => 'No country found'
            ], 404);
        }

        return response()->json($countries);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|string|max:15|unique:users',
        'address' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        'country_id' => 'required|exists:countries,id',
        'password' => 'required|string|min:8|confirmed',
    ]);

    try {
          $imageName = time().'.'.$request->image->getClientOriginalExtension();
          $request->image->storeAs('public/images', $imageName);

          $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'address' => $validated['address'],
            'image' => $imageName,
            'country_id' => $validated['country_id'],
            'password' => Hash::make($validated['password']),
          ]);

         $token = $user->createToken('auth_token')->plainTextToken;

         return response()->json(['user' => $user, 'token' => $token], 201);
        }   catch (\Exception $e) {
         return response()->json(['message' => 'Failed to register user.'], 500);
        }
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $validated['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
