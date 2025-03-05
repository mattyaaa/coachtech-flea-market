<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    // 商品購入画面を表示する
    public function show($item_id)
    {
        $item = Product::findOrFail($item_id);
        $user = Auth::user();

        // プロフィールが存在しない場合は新しいプロフィールを作成
        if (!$user->profile) {
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->profile_image = '';
            $profile->name = '';
            $profile->postal_code = '';
            $profile->address = '';
            $profile->save();
        } else {
            $profile = $user->profile;
        }

        return view('purchase.show', compact('item', 'profile'));
    }

    // 商品購入処理
    public function purchase(Request $request, $item_id)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:8',
            'phone_number' => 'required|string|max:15',
            'payment_method' => 'required|string|in:コンビニ支払い,カード支払い',
        ]);

        // 購入完了後の画面にリダイレクト
        return redirect('/')->with('status', '購入手続きが完了しました。');
    }

    // 送付先住所変更画面を表示する
    public function changeAddress($item_id)
    {
        $item = Product::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;
        return view('purchase.change-address', compact('item', 'profile'));
    }

    // 送付先住所変更処理
    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:8',
            'phone_number' => 'required|string|max:15',
        ]);

        $user = Auth::user();
        $profile = $user->profile;
        $profile->address = $request->input('address');
        $profile->postal_code = $request->input('postal_code');
        $profile->phone_number = $request->input('phone_number');
        $profile->save();

        return redirect()->route('purchase.show', ['item_id' => $item_id])->with('status', '住所が更新されました。');
    }
}