<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;


class PurchaseController extends Controller
{
    // 商品購入画面表示
    public function purchase($itemId)
    {
        $item = Item::findOrFail($itemId);
        $user = Auth::user();

        return view('items.purchase', ['item' => $item, "user" => $user]);
    }


    // 商品購入処理
    // public function payment(PurchaseRequest $purchaseRequest,$itemId)
    public function payment(Request $request, $itemId)
    {
        // 購入者、商品情報などを取得
        $item = Item::findOrFail($itemId);
        $user = Auth::user();

        // 支払い方法の選択を取得
        // $paymentMethod = $purchaseRequest->input('payment_method');
        $paymentMethod = $request->input('payment_method');

        // // 購入テーブルに新規データを作成
        // $purchase = Purchase::create([
        //     'user_id' => $user->id,
        //     'item_id' => $item->id,
        //     'purchase_status' => 0, // 購入ステータスを「０：未完了」で登録
        //     'payment_method' => $paymentMethod == 'card' ? 1 : 2, // 1:カード, 2:コンビニ
        //     'stripe_payment_id' => null, // 仮置き（後で更新）
        //     'sending_address' => $user->address,
        // ]);

        // Stripeの秘密鍵を設定
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // Stripeの決済セッションを作成
        $session = Session::create([

            // 'payment_method_types' => $paymentMethod == 'card' ? ['card'] : ['convenience_store'], // 支払い方法に応じて設定
            'payment_method_types' => [$paymentMethod], // 支払い方法に応じて設定
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->item_name,
                        ],
                        // 'unit_amount' => $item->price * 100, // 金額は最小単位（円単位）
                        'unit_amount' => $item->price, // 金額は最小単位（円単位）
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            // 'success_url' => route('item.purchase.success', ['itemId' => $item->id, 'purchase_id' => $purchase->id,]),
            // 'success_url' => route('item.purchase.success', ['itemId' => $item->id, 'purchase_id' => '{CHECKOUT_SESSION_ID}', // 仮置き→URLがそのままプレースホルダーの形で出力されてしまう
            // ]),
            'success_url' => url("/purchase/{$item->id}/success?purchase_id={CHECKOUT_SESSION_ID}"),

            // 'cancel_url' => route('payment.cancel'),

        ]);

        // // StripeのセッションIDを更新
        // $purchase->update([
        //     'stripe_payment_id' => $session->id,
        // ]);

        // 購入テーブルに新規データを作成
        $purchase = Purchase::create([

            'user_id' => $user->id,
            'item_id' => $item->id,
            'purchase_status' => 0, // 購入ステータスを「０：未完了」で登録
            'payment_method' => $paymentMethod == 'card' ? 1 : 2, // 1:カード, 2:コンビニ
            'stripe_payment_id' => $session->id, // Stripeの決済ID
            'sending_address' => $user->address,

        ]);

        // Stripeの決済ページにリダイレクト
        return redirect($session->url);
        // return to_route($session->url);

        //  return view('items.purchase', ['item' => $item, "user" => $user]);
    }



    public function success(Request $request)
    {
        // // リクエストからpurchase_idを取得
        // $purchase = Purchase::find($request->input('purchase_id'));
        $purchase = Purchase::where('stripe_payment_id', $request->input('purchase_id'))->first();


        // Stripeの秘密鍵を設定
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                // セッションIDを使って決済情報を取得
        $session = Session::retrieve($purchase->stripe_payment_id);

        // 支払いが完了しているかをチェック
        if ($session->payment_status == 'paid') {

            // 購入ステータスを「完了」に更新
            $purchase->update(['purchase_status' => 1]); // 1: 完了
        }

        // 成功画面を表示
        // return view('profile.show-buy');
        return to_route('profile.show.buy');
    }


    // public function success(Request $request, $itemId)
    // {
    //     // Stripeの秘密鍵を設定
    //     $stripeSecret = env('STRIPE_SECRET_KEY');
    //     if (!$stripeSecret) {
    //         return response()->json(['error' => 'Stripe API key not set'], 500);
    //     }

    //     Stripe::setApiKey($stripeSecret);

    //     // stripe_payment_idでPurchaseを検索
    //     $purchase = Purchase::where('stripe_payment_id', $request->input('purchase_id'))->first();

    //     if (!$purchase) {
    //         return response()->json(['error' => 'Purchase not found'], 404);
    //     }

    //     // セッションIDを使って決済情報を取得
    //     $session = Session::retrieve($purchase->stripe_payment_id);

    //     if ($session->payment_status == 'paid') {
    //         $purchase->update(['purchase_status' => 1]); // 購入ステータスを完了に更新
    //     }

    //     return view('profile.show-buy');
    // }



}
