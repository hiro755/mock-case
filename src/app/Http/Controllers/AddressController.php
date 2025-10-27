<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function create(Request $request)
{
    $item_id = $request->query('item_id');
    return view('address.create', ['item_id' => $item_id]);
}

    public function store(Request $request)
    {

        $request->validate([
            'postal_code'   => 'required|string|max:8',
            'address'       => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        Address::create([
            'user_id'       => auth()->id(),
            'postal_code'   => $request->postal_code,
            'address'       => $request->address,
            'building_name' => $request->building_name,
        ]);

        $item_id = $request->input('item_id');

        return redirect()->route('purchase.address', ['item_id' => $item_id])
                        ->with('success', '住所を登録しました');
    }

    public function edit(Request $request, $id)
{
    $address = Address::findOrFail($id);
    $item_id = $request->query('item_id');
    return view('address.edit', compact('address', 'item_id'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'postal_code'   => 'required|string|max:8',
            'address'       => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        $address = Address::findOrFail($id);
        $address->update($request->only('postal_code', 'address', 'building_name'));

        $item_id = $request->input('item_id');

        return redirect()->route('purchase.address', ['item_id' => $item_id])
                        ->with('success', '住所を更新しました');
    }
}
