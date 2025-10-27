<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $like = Like::where('user_id', $user->id)
                    ->where('product_id', $id)
                    ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $user->id,
                'product_id' => $id,
            ]);
        }

        return back();
    }
}