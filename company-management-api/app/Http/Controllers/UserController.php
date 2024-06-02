<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user());
    }

    public function update(Request $request)
   {
        $user = Auth::user();

     try{
         $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'mobile' => 'required|string|max:15|unique:users,mobile,' . $user->id,
            'address' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->storeAs('public/images', $imageName);
            $user->image = $imageName;
        }

        $user->full_name = $validated['full_name'];
        $user->email = $validated['email'];
        $user->mobile = $validated['mobile'];
        $user->address = $validated['address'];
        $user->country_id = $validated['country_id'];
        $user->password = $validated['password'] ? Hash::make($validated['password']) : $user->password;
        $user->save();

        return response()->json($user);
      } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to update user.'], 500);
      }
    }

}
