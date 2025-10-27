<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PaymentController extends Controller
{
    public function showCardForm($item_id)
    {
        $product = Product::findOrFail($item_id);
        return view('payments.card-confirm', compact('product'));
    }

    public function card(Request $request)
    {
        $productId = $request->input('item_id');
        $product = Product::findOrFail($productId);
        $product->buyer_id = auth()->id();
        $product->save();

        return redirect()->route('payment.card.complete', ['item_id' => $productId]);
    }

    public function showConvenienceConfirm($item_id)
    {
        $product = Product::findOrFail($item_id);
        return view('payments.convenience-confirm', compact('product'));
    }

    public function convenience(Request $request)
    {
        $productId = $request->input('item_id');
        $product = Product::findOrFail($productId);
        $product->buyer_id = auth()->id();
        $product->save();

        return redirect()->route('payment.convenience.complete', ['item_id' => $productId]);
    }
}