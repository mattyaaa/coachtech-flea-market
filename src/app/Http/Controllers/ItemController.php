<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // 商品一覧画面（トップ画面）
    public function index()
    {
        $items = Product::all();
        return view('item.index', compact('items'));
    }

    // 商品一覧画面（トップ画面）_マイリスト
    public function myList()
    {
        $user = Auth::user();
        $items = $user->favorites; // assuming there is a relationship defined in the User model
        return view('item.index', compact('items'));
    }

    // 商品詳細画面
    public function show($item_id)
    {
        $item = Product::with('comments.user', 'categories', 'condition', 'brand')->findOrFail($item_id);
        return view('item.show', compact('item'));
    }

    // 商品出品画面
    public function create()
    {
        return view('item.create');
    }

    // 商品出品処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $item = new Product();
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->price = $request->input('price');
        $item->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('item_images', 'public');
            $item->image = $filePath;
        }

        $item->save();

        return redirect('/')->with('status', '商品が出品されました。');
    }

}
