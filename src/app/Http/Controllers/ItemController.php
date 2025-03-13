<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // 商品一覧画面（トップ画面）
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'recommend');
        $search = $request->query('search', '');

        if ($tab == 'mylist') {
            if ($user) {
                $items = Product::where('name', 'LIKE', "%{$search}%")
                    ->whereHas('favorites', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->get();
            } else {
                $items = collect(); // 空のコレクションを返す
            }
        } else {
            $items = Product::where('name', 'LIKE', "%{$search}%")
                ->where(function ($query) use ($user) {
                    if ($user) {
                        // 自分が出品した商品を除外
                        $query->where('user_id', '!=', $user->id);
                    }
                })->get();
        }

        return view('item.index', compact('items', 'tab', 'search'));
    }

    // 商品詳細画面
    public function show($item_id)
    {
        $item = Product::with(['comments.user', 'categories', 'condition'])->findOrFail($item_id);
        $item->formatted_price = '¥' . number_format($item->price) . ' (税込)';
        $item->comments_count = $item->comments()->count();
        $item->favorites_count = $item->favorites()->count();

        return view('item.show', compact('item'));
    }

    // 商品出品画面
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('item.create', compact('categories', 'conditions'));
    }

    // 商品出品処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'brand' => 'nullable|string|max:255',
        ]);

        $item = new Product();
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->price = $request->input('price');
        $item->user_id = Auth::id();
        $item->brand = $request->input('brand');

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('item_images', 'public');
            $item->image = $filePath;
        }

        $item->save();

        return redirect('/')->with('status', '商品が出品されました。');
    }

    // 商品へのコメント追加処理
    public function addComment(Request $request, $item_id)
    {
        $request->validate([
            'comment' => 'required|string'
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->product_id = $item_id;
        $comment->content = $request->input('comment');
        $comment->save();

        return redirect()->back()->with('status', 'コメントが追加されました。');
    }
}