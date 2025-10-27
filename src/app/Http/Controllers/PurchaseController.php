<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function address($item_id)
    {
        $product = Product::findOrFail($item_id);
        $address = Address::where('user_id', auth()->id())->first();

        return view('purchase.address', compact('product', 'address', 'item_id'));
    }

    public function store(PurchaseRequest $request, $item_id)
{
    $validated = $request->validated();
    $paymentMethod = $validated['payment_method'] ?? null;

    if ($paymentMethod === 'カード支払い') {
        return redirect()->route('payment.card.show', ['item_id' => $item_id]);
    }

    $product = Product::findOrFail($item_id);
    $product->buyer_id = auth()->id();
    $product->save();

    return redirect()->route('payment.convenience', ['item_id' => $product->id]);
}
}