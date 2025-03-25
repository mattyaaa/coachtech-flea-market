<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Profile;

class ProfileController extends Controller
{
    // プロフィール画面を表示する
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile;

        // 出品した商品を取得
        $products = $user->products;

        // 購入した商品を取得
        $purchases = $user->purchases;

        return view('profile.show', compact('user', 'profile', 'products', 'purchases'));
    }

    // プロフィール編集画面を表示する
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;

        // プロフィールが存在しない場合、新しいプロファイルを作成
        if (!$profile) {
        $profile = new Profile(['user_id' => $user->id]);
        $profile->save();
        }

        return view('profile.edit', compact('user', 'profile'));
    }

    // プロフィールを更新する
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?: new Profile(['user_id' => $user->id]);

        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // プロフィール画像のアップロード
        if ($request->hasFile('profile_image')) {
            // 古い画像を削除
            if ($profile->profile_image) {
                Storage::disk('public')->delete($profile->profile_image);
            }
            // 新しい画像を保存
            $filePath = $request->file('profile_image')->store('profile_images', 'public');
            $profile->profile_image = $filePath;
        }

        // その他のフィールドの更新
        $profile->name = $request->input('name');
        $profile->postal_code = $request->input('postal_code');
        $profile->address = $request->input('address');
        $profile->building_name = $request->input('building_name');
        $profile->save();

        return redirect()->route('profile.edit')->with('status', 'プロフィールが更新されました。');
    }

    // 購入した商品一覧を表示する
    public function showPurchases()
    {
        $user = Auth::user();
        $purchases = $user->purchases()->with('product')->get();
        return view('profile.showPurchases', compact('user', 'purchases'));
    }

    // 出品した商品一覧を表示する
    public function showSales()
    {
        $user = Auth::user();
        $products = $user->products()->get();
        return view('profile.showSales', compact('user', 'products'));
    }
}