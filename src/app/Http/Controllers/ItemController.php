<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Favorite;
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
            'condition_id' => 'required|exists:conditions,id',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->user_id = Auth::id();
        $product->brand = $request->input('brand');
        $product->condition_id = $request->input('condition_id');

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('item_images', 'public');
            $product->image = $filePath;
        }

        $product->save();
        $product->categories()->sync($request->input('categories', []));

        return redirect('/')->with('status', '商品が出品されました。');
    }

    // 商品へのコメント追加処理
    public function addComment(CommentRequest $request, $item_id)
    {
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->product_id = $item_id;
        $comment->comment = $request->input('comment');
        $comment->save();

        return redirect()->back()->with('status', 'コメントが追加されました。');
    }

    // いいね追加処理
    public function addFavorite(Request $request, $item_id)
    {
    $user_id = Auth::id();

    // すでにいいねしているか確認
    $favorite = Favorite::where('user_id', $user_id)->where('product_id', $item_id)->first();

    if ($favorite) {
        // すでにいいねしている場合は何もしない
        return response()->json(['success' => false, 'message' => 'Already liked']);
    }

    // いいねを登録
    Favorite::create([
        'user_id' => $user_id,
        'product_id' => $item_id,
    ]);

    // いいねの合計値を取得
    $favorites_count = Favorite::where('product_id', $item_id)->count();

    return response()->json(['success' => true, 'favorites_count' => $favorites_count]);
    }

    //いいね機能解除処理
    public function removeFavorite(Request $request, $item_id)
    {
    $user_id = Auth::id();

    // いいねを解除
    Favorite::where('user_id', $user_id)->where('product_id', $item_id)->delete();

    // いいねの合計値を取得
    $favorites_count = Favorite::where('product_id', $item_id)->count();

    return response()->json(['success' => true, 'favorites_count' => $favorites_count]);
    }
}