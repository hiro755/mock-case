<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileSetupController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.setup', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:50',
        ]);

        $user = auth()->user();
        $user->fill($request->only(['name', 'nickname']));
        $user->profile_completed = true;
        $user->save();

        return redirect()->route('products.index');
    }
}