<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        Comment::create([
            'user_id'    => Auth::id(),
            'product_id' => $id,
            'content'    => $request->input('content'),
        ]);

        return back()->with('success', 'コメントを投稿しました。');
    }
}