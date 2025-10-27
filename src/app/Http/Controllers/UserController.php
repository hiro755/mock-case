<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function mypage()
    {
        $user = auth()->user();
        $user->load(['exhibited_items', 'purchased_items']);

        return view('profile.mypage', compact('user'));
    }

    public function edit()
    {
        return view('mypage.profile_edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:20',
            'icon' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $user->icon = $path;
        }

        $user->name = $request->name;
        $user->zipcode = $request->zipcode;
        $user->address = $request->address;
        $user->tel = $request->tel;
        $user->save();

        return redirect()->route('mypage.user')->with('status', 'プロフィールを更新しました');
    }
}