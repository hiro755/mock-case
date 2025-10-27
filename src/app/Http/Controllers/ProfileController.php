<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('profile.setup', compact('user'));
    }

    public function store(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->full_name    = $request->full_name;
        $user->postal_code  = $request->postal_code;
        $user->address      = $request->address;
        $user->building     = $request->building;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        return redirect()->route('mypage')->with('success', 'プロフィールを設定しました。');
    }

    public function mypage()
    {
        $user = Auth::user();
        return view('profile.mypage', compact('user'));
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $user->name         = $request->full_name;
        $user->full_name    = $request->full_name;
        $user->postal_code  = $request->postal_code;
        $user->address      = $request->address;
        $user->building     = $request->building;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました。');
    }
}