<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Purchase;
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
            $profile->postal_code = '';
            $profile->address = '';
            $profile->building_name = '';
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
            'payment_method' => 'required|string|in:コンビニ支払い,カード支払い',
        ]);

        $item = Product::findOrFail($item_id);

        // 購入処理
        $purchase = new Purchase();
        $purchase->user_id = Auth::id();
        $purchase->product_id = $item->id;
        $purchase->payment_method = $request->payment_method;
        $purchase->delivery_address = $request->delivery_address ?? '';
        $purchase->save();

        // 商品のステータスを"sold"に更新
        $item->status = 'sold';
        $item->save();

        // 購入完了後の画面にリダイレクト
        return redirect('/')->with('status', '購入手続きが完了しました。');
    }

    // 住所変更画面を表示する
    public function editAddress($item_id)
    {
        $item = Product::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;
        return view('purchase.edit_address', compact('item', 'profile'));
    }

    // 送付先住所変更処理
    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'postal_code' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $profile = $user->profile;
        $profile->postal_code = $request->input('postal_code');
        $profile->address = $request->input('address');
        $profile->building_name = $request->input('building_name');
        $profile->save();

        return redirect()->route('purchase.show', ['item_id' => $item_id])->with('status', '住所が更新されました。');
    }
}