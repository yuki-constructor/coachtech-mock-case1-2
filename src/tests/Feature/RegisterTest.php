<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;


// ===================================================
//  （テスト項目）
// １ 会員登録機能
// ===================================================


class RegisterTest extends TestCase
{
    // データベーストランザクションを利用
    use DatabaseTransactions;

    // ===================================================
    //  （テスト内容）
    // ・名前が入力されていない場合、バリデーションメッセージが表示される
    // ・メールアドレスが入力されていない場合、バリデーションメッセージが表示される
    // ・パスワードが入力されていない場合、バリデーションメッセージが表示される
    // ・パスワードが7文字以下の場合、バリデーションメッセージが表示される
    // ・パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される
    // ===================================================
    /**
     * @dataProvider registrationValidationProvider
     */
    public function test_user_registration_validation($field, $value, $expectedError)
    {
        // 会員登録ページを開く
        $response = $this->get(route('register'));

        // ステータスコード 200 を確認
        $response->assertStatus(200);

        $data = [
            'name' => 'test user',
            'email' => 'user@example.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ];

        // テスト対象のフィールドの値を変更
        $data[$field] = $value;

        $response = $this->post(route('user.store'), $data);

        $response->assertSessionHasErrors([$field => $expectedError]);
    }

    // データプロバイダ
    public static function registrationValidationProvider()
    {
        return [
            '名前が必須' => ['name', '', 'お名前を入力してください'],
            'メールアドレスが必須' => ['email', '', 'メールアドレスを入力してください'],
            'パスワードが必須' => ['password', '', 'パスワードを入力してください'],
            'パスワードが７文字以下' => ['password', '123', 'パスワードは8文字以上で入力してください'],
            'パスワードが確認用パスワードと不一致' => ['password', '987654321', 'パスワードと一致しません'],
            // 'パスワードが確認用パスワードと不一致' => ['password_confirmation', '987654321', 'パスワードと一致しません'],
            // password_confirmation に、confirmed ルールを設定していないため（password_confirmation に、confirmed ルールを設定すると、パスワードと確認用パスワードが一致していても、バリデーションエラーとなるため、password に、confirmed ルールを設定しているため）password_confirmation のテストがエラーとなる。
        ];
    }

    // ===================================================
    //  （テスト内容）
    // 全ての項目が入力されている場合、会員情報が登録され、ログイン画面に遷移される
    // ===================================================

    // public function test_user_registration()
    // {
    //     $response = $this->post(route('user.store'), [
    //         'name' => 'test user',
    //         'email' => 'user@example.com',
    //         'password' => '123456789',
    //         'password_confirmation' => '123456789',
    //     ]); //仮のユーザーデータをusersテーブルに登録

    //     $this->assertDatabaseHas('users', ['email' => 'test@example.com']);// データベースにユーザーが登録されたことを確認
    //     $response->assertRedirect(route('login')); // ログイン画面へ遷移するか確認
    // }


    // public function test_user_registration()
    // {
    //     $userData = User::factory()->make()->toArray(); // 仮のユーザーデータを作成

    //     $userData['password'] = '123456789'; // パスワードを追加
    //     $userData['password_confirmation'] = '123456789'; // 確認用パスワードを追加

    //     $response = $this->post(route('user.store'), $userData);// 仮のユーザーデータをusersテーブルに登録

    //     $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    //     $response->assertRedirect(route('login'));
    // }


    protected $userData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userData = User::factory()->make()->toArray(); // テストごとに新しいユーザー情報を生成
    }

    public function test_user_registration()
    {

        // 会員登録ページを開く
        $response = $this->get(route('register'));

        // ステータスコード 200 を確認
        $response->assertStatus(200);

        $this->userData['password'] = '123456789';
        $this->userData['password_confirmation'] = '123456789';

        $response = $this->post(route('user.store'), $this->userData); // 仮のユーザーデータをusersテーブルに登録

        $this->assertDatabaseHas('users', ['email' => $this->userData['email']]);
        $response->assertRedirect(route('login'));
    }
}
