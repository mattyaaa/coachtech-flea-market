<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //プロフィール画面を表示する
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    //プロフィール編集画面を表示する
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    //プロフィールを更新する
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // プロフィール画像のアップロード
        if ($request->hasFile('profile_image')) {
            $filePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $filePath;
        }

        // その他のフィールドの更新
        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');
        $user->first_login = false;
        $user->save();

        return redirect('/mypage')->with('status', 'プロフィールが更新されました。');
    }

    //購入した商品一覧を表示する
    public function showPurchases()
    {
        $user = Auth::user();
        return view('profile.showPurchases', compact('user'));
    }

    //出品した商品一覧を表示する
    public function showSales()
    {
        $user = Auth::user();
        return view('profile.showSales', compact('user'));
    }
}
