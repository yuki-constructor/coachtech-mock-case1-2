<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class EmailVerificationController extends Controller
{
    public function verify($token)
    {
        // トークンに一致するユーザーを取得
        $user = User::where('email_verification_token', $token)->first();

        if ($user) {
            // トークンを削除して認証を完了
            $user->email_verification_token = null;
            $user->save();

            // 初回ログインの場合はプロフィール登録ページにリダイレクト
            if ($user->is_first_login) {
                $user->is_first_login = false;
                $user->save();

                return redirect()->route('profile.create'); // プロフィール登録ページにリダイレクト
            }
            // メール認証成功後、元々アクセスしたページにリダイレクト
            return redirect()->intended();
            // return to_route('login');
        }
        // トークンが無効の場合
        return redirect()->route('login')->with('error', '無効な認証トークンです');
    }
}
