<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {
            $products = auth()->check()
                ? auth()->user()->likes()->with('product')->get()->pluck('product')
                : collect();
        } else {
            $query = Product::query();

            if (auth()->check()) {
                $query->where('user_id', '!=', auth()->id());
            }

            if (!empty($keyword)) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhereHas('user', function ($subQuery) use ($keyword) {
                            $subQuery->where('name', 'like', "%{$keyword}%");
                        });
                });
            }

            $products = $query->get();
        }

        return view('products.index', [
            'products' => $products,
            'tab' => $tab,
            'user' => auth()->user(),
        ]);
    }

    public function show($id)
    {
        $product = Product::with(['comments.user'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();

        $product = new Product();
        $product->name        = $validated['name'];
        $product->brand       = $validated['brand'] ?? null;
        $product->description = $validated['description'] ?? null;
        $product->condition   = $validated['condition'] ?? null;
        $product->price       = $validated['price'];
        $product->category    = $validated['category'];
        $product->user_id     = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image_path = $path;
        }

        $product->save();

        return redirect()->route('mypage')->with('success', '商品を出品しました。');
    }

    public function myProducts()
    {
        $user = auth()->user();
        $user->refresh();

        $exhibited = Product::where('user_id', $user->id)->get()->map(function ($product) {
            $product->is_sold = !is_null($product->buyer_id);
            return $product;
        });

        $purchased = Product::where('buyer_id', $user->id)->get()->map(function ($product) {
            $product->is_sold = !is_null($product->buyer_id);
            return $product;
        });

        return view('profile.mypage', [
            'user' => $user,
            'exhibited' => $exhibited,
            'purchased' => $purchased,
        ]);
    }

    public function myList()
    {
        $user = auth()->user();
        $products = $user->likes()->with('product')->get()->pluck('product');

        return view('products.index', [
            'products' => $products,
            'tab' => 'mylist',
            'user' => $user,
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== auth()->id()) {
            abort(403, 'この商品を削除する権限がありません。');
        }

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('mypage')->with('success', '商品を削除しました。');
    }
}