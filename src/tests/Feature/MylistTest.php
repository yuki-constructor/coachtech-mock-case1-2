<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


// ===================================================
//  （テスト項目）
// 5 マイリスト一覧取得
// ===================================================

class MylistTest extends TestCase
{

    // データベーストランザクションを利用
    use DatabaseTransactions;

    // ===================================================
    // セットアップ
    // ===================================================

    protected $user;
    protected $otherUser;
    protected $userItem;
    protected $otherUserItem;
    // protected $sellItem;
    protected $userLikeItem;
    protected $otherUserLikeItem;
    // protected $purchaseItem;

    protected function setUp(): void
    {
        parent::setUp();

        // ログインユーザーを作成
        $this->user = User::factory()->create();
        // $this->actingAs($this->user);

        // 他のユーザーを作成
        $this->otherUser = User::factory()->create();

        // ログインユーザーの商品を作成
        $this->userItem = Item::create([
            'user_id' => $this->user->id,
            'item_name' => 'テスト商品(MylistTest・ログインユーザー出品・その他のユーザーいいね済み',
            'item_image' => 'test_image.jpg',
            'brand' => 'テストブランド',
            'price' => 1000,
            'description' => 'テスト商品の説明',
        ]);

        // 他のユーザーの商品を作成
        $this->otherUserItem = Item::create([
            'user_id' => $this->otherUser->id,
            'item_name' => 'テスト商品（MylistTest・その他のユーザー出品・ログインユーザーいいね済み）',
            'item_image' => 'test_image.jpg',
            'brand' => 'テストブランド',
            'price' => 1000,
            'description' => 'テスト商品の説明',
        ]);

        // ログインユーザーが他のユーザーの商品に「いいね」する
        $this->user->likeItem()->attach($this->otherUserItem->id);
        $this->userLikeItem = $this->otherUserItem;

        // 他のユーザーがログインユーザーの商品に「いいね」する
        $this->otherUser->likeItem()->attach($this->userItem->id);
        $this->otherUserLikeItem = $this->userItem;

        // // 他のユーザーの商品(ログインユーザーが購入済)を作成
        // $this->purchaseItem = Item::create([
        //     'user_id' => $this->otherUser->id,
        //     'item_name' => 'テスト商品（MylistTest・その他のユーザー出品・ログインユーザー購入済み）',
        //     'item_image' => 'test_image.jpg',
        //     'brand' => 'テストブランド',
        //     'price' => 1000,
        //     'description' => 'テスト商品の説明',
        // ]);


        // $purchaseItemに購入済みを設定
        // $this->user->purchases()->attach($this->purchaseItem->id);
        // $this->user->purchases()->create([
        //     'item_id' => $this->purchaseItem->id,
        // ]);

        // Purchase::create([
        //     'item_id' => $this->purchaseItem->id,
        //     'user_id' => $this->user->id,, // ログインユーザーが購入
        //     'purchase_status' => 1, // 購入済み
        //     'payment_method' => 1, // クレジットカード
        //     'stripe_payment_id' => 'test_payment_123',
        //     'sending_address' => '東京都渋谷区',
        // ]);

        //  // ログインユーザーの商品を作成
        //  $userItem = Item::create(array_merge($sellData, ['user_id' => $user->id]));

        // // 他のユーザーの商品(ログインユーザーがいいね済)を作成
        // $likeItem = Item::create(array_merge($likeData, ['user_id' => $this->otherUser->id])); // 異なる user_id（他のユーザー）

        // // $likeItemにいいねを設定
        // $this->user->likeItem()->attach($this->likeItem->id);

        // // 他のユーザーの商品(ログインユーザーが購入済)を作成
        // $purchaseItem = Item::create(array_merge($purchaseData, ['user_id' => $this->otherUser->id])); // 異なる user_id（他のユーザー）

        // // $purchaseItemに購入済みを設定
        // $this->user->purchase()->attach($this->purchaseItem->id);
    }

    // /**
    //  * 他のユーザーが出品した商品のデータプロバイダ
    //  */
    // public static function itemsLikeProvider()
    // {
    //             return [
    //         'テスト商品' => [
    //             'sellData' => [
    //                 'item_name' => 'テスト商品(MylistTest・ログインユーザー出品',
    //                 'item_image' => 'test_image.jpg',
    //                 'brand' => 'テストブランド',
    //                 'price' => 1000,
    //                 'description' => 'テスト商品の説明',
    //             ],
    //             'likeData' => [
    //                 'item_name' => 'テスト商品（MylistTest・その他のユーザー出品・ログインユーザーいいね済み）',
    //                 'item_image' => 'test_image.jpg',
    //                 'brand' => 'テストブランド',
    //                 'price' => 1000,
    //                 'description' => 'テスト商品の説明',
    //             ],
    //             'purchaseData' => [
    //                 'item_name' => 'テスト商品（MylistTest・その他のユーザー出品・ログインユーザー購入済み）',
    //                 'item_image' => 'test_image.jpg',
    //                 'brand' => 'テストブランド',
    //                 'price' => 1000,
    //                 'description' => 'テスト商品の説明',
    //             ],
    //         ],
    //     ];
    // }


    // ===================================================
    //  （テスト内容）いいねした商品だけが表示される
    // ===================================================
    public function test_items_like()
    {
        // // ユーザーを作成してログイン
        // $user = User::factory()->create();
        // $this->actingAs($user);

        // // 他のユーザーを作成
        // $otherUser = User::factory()->create();
        // // // 他のユーザーの商品名をテスト毎に変更
        // // $otherData['item_name'] .= ' - ' . $otherUser->name;
        // // 他のユーザーの商品を作成
        // $otherUserItem = Item::create(array_merge($otherData, ['user_id' => $otherUser->id])); // 異なる user_id（他のユーザー）

        // // いいねした商品
        // $user->likeItem()->attach($otherUserItem->id);

        // セットアップで指定したログインユーザーでアクセス
        $this->actingAs($this->user);

        // マイリストページページを開く
        $response = $this->get(route('items.index.mylist'));

        // ステータスコード 200 を確認
        $response->assertStatus(200);

        // ログインユーザーがいいねした商品($userLikeItem)が表示される。他のユーザーがいいねした商品（$otherUserLikeItem）は表示されない
        $response->assertSee($this->userLikeItem->item_name);
    }

    // /**
    //  * いいねした商品のデータプロバイダ
    //  */
    // public static function itemsLikeProvider()
    // {
    //     return [
    //         'テスト商品' => [
    //             'otherData' => [
    //                 'item_name' => 'テスト商品（MylistTest・いいね済み）',
    //                 'item_image' => 'test_image.jpg',
    //                 'brand' => 'テストブランド',
    //                 'price' => 1000,
    //                 'description' => 'テスト商品の説明',
    //             ],
    //         ],
    //     ];
    // }

    // ===================================================
    //  （テスト内容）購入済み商品は「Sold」と表示される
    // ===================================================
    public function test_items_sold_out()
    {
        // // ユーザーを作成してログイン
        // $user = User::factory()->create();
        // $this->actingAs($user);

        // // 他のユーザーを作成
        // $otherUser = User::factory()->create();
        // // // 他のユーザーの商品名をテスト毎に変更
        // // $otherData['item_name'] .= ' - ' . $otherUser->name;
        // // 他のユーザーの商品を作成
        // $otherUserItem = Item::create(array_merge($itemData, ['user_id' => $otherUser->id])); // 異なる user_id（他のユーザー）

        // // // 商品を購入
        // // Purchase::factory()->create([
        // //     'user_id' => $user->id,
        // //     'item_id' => $soldItem->id,
        // //     'purchase_status' => 1, // 購入済み
        // // ]);

        // // 購入データを作成（購入済み）
        // Purchase::create(array_merge($purchaseData, ['item_id' => $otherUserItem->id, 'user_id' => $user->id]));

        // セットアップで指定したログインユーザーでアクセス
        $this->actingAs($this->user);

        // 購入データを作成（購入済み）
        $purchaseItem = Purchase::create([
            'item_id' => $this->userLikeItem->id, // ログインユーザーがいいねした商品
            'user_id' => $this->user->id, // ログインユーザーが購入
            'purchase_status' => 1,
            'payment_method' => 1,
            'stripe_payment_id' => 'test_payment_123',
            'sending_address' => '東京都渋谷区',
        ]);

        // マイリストページページを開く
        $response = $this->get(route('items.index.mylist'));

        // ステータスコード 200 を確認
        $response->assertStatus(200);

        // 購入済み商品に「Sold」のラベルが表示されていることを確認
        $response->assertSee('SOLD ' . $purchaseItem->item_name);
    }

    // /**
    //  * 購入済み商品のデータプロバイダ
    //  */
    // public static function soldOutProvider()
    // {
    //     return [
    //         '購入済みのテスト商品' => [
    //             'itemData' => [
    //                 // 'user_id' => 1, // 出品者ID
    //                 'item_name' => 'テスト商品(MylistTest・購入済み)',
    //                 'item_image' => 'test_image.jpg',
    //                 'brand' => 'テストブランド',
    //                 'price' => 1000,
    //                 'description' => 'テスト商品の説明',
    //             ],
    //             'purchaseData' => [
    //                 // 'user_id' => 2, // 購入者ID
    //                 'purchase_status' => 1, // 購入済み
    //                 'payment_method' => 1, // クレジットカード
    //                 'stripe_payment_id' => 'test_payment_123',
    //                 'sending_address' => '東京都渋谷区',
    //             ],
    //         ],
    //     ];
    // }

    // ===================================================
    //  （テスト内容）自分が出品した商品は表示されない
    // ===================================================
    public function test_items_sold_by_users()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        // // 自分が出品した商品
        // $ownItem = Item::factory()->create(['user_id' => $user->id]);

        // セットアップで指定したログインユーザーでアクセス
        $this->actingAs($this->user);

        // マイリストページページを開く
        $response = $this->get(route('items.index.mylist'));

        // ステータスコード 200 を確認
        $response->assertStatus(200);

        // ログインユーザーが出品した商品が表示されないことを確認
        $response->assertDontSee($this->userItem->item_name);

        // その他のユーザーが出品した商品で、ログインユーザーがいいねした商品が表示されることを確認
        $response->assertSee($this->userLikeItem->item_name);
    }


    // ===================================================
    //  （テスト内容）未認証の場合は何も表示されない
    // ===================================================
    public function test_unauthenticated_user()
    {
        // // 未ログイン設定
        // $this->withoutMiddleware();

        // マイリストページへアクセス（未ログイン）
        $response = $this->get(route('items.index.mylist'));

        // ステータスコード 200 を確認
        $response->assertStatus(200);

        // 何も表示されない（商品のリストが空）
        $response->assertSee('マイリスト'); // 画面のタイトルがあることを確認
        $response->assertDontSee('<div class="item">'); // 商品リストが表示されない
    }
}
