<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;



class ProfileController extends Controller
{
    // プロフィール設定画面を表示
    public function create()
    {
        return view('profile.create'); // プロフィール設定画面
    }

    // プロフィール登録処理
    // public function store(ProfileRequest $profileRequest, AddressRequest $addressRequest)
    // public function store(ProfileRequest $profileRequest, Request $request)
    public function store(ProfileRequest $profileRequest)
    // public function store(Request $request)
    {
        /** @var \App\Models\User $user */

        $user = Auth::user(); // ログイン中のユーザーを取得

        // プロフィール画像の保存（存在する場合のみ）
        $path = null;

        if ($profileRequest->hasFile('profile_image')) {
            // if ($request->hasFile('profile_image')) {

            // 画像をストレージに保存
            $path = basename($profileRequest->file('profile_image')->store('photos/profile_images', 'public'));
            // $path = $request->file('profile_image')->store('photos/profile_images', 'public');

        }

        // プロフィール情報と住所情報をユーザーに保存
        $user->update([
            // 'name' => $addressRequest->input('name'),  // 住所リクエストから名前を取得
            'name' => $profileRequest->input('name'),  // リクエストから名前を取得
            'profile_image' => $path,
            // 'postal_code' => $addressRequest->input('postal_code'),
            'postal_code' => $profileRequest->input('postal_code'),
            // 'address' => $addressRequest->input('address'),
            'address' => $profileRequest->input('address'),
            // 'building' => $addressRequest->input('building'),
            'building' => $profileRequest->input('building'),
        ]);

        return redirect()->route('item.mylist'); // 商品一覧画面（マイリスト）にリダイレクト

    }

    // プロフィール表示画面
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]); // プロフィール情報を表示
    }

    // プロフィール編集画面
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }


    // プロフィール更新処理
    // public function update(ProfileRequest $profileRequest, AddressRequest $addressRequest)
    public function update(ProfileRequest $profileRequest)
    {
        $user = Auth::user(); // ログイン中のユーザーを取得

        // プロフィール画像の保存（新しい画像が送信されている場合のみ）
        $path = $user->profile_image; // 初期値として既存の画像を使用
        if ($profileRequest->hasFile('profile_image')) {
            // 古い画像があれば削除
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            // 新しい画像を保存
            $path = basename($profileRequest->file('profile_image')->store('photos/profile_images', 'public'));
        }

        // ユーザー情報の更新
        $user->update([
            // 'name' => $addressRequest->input('name'),
            'name' => $profileRequest->input('name'),
            'profile_image' => $path,
            // 'postal_code' => $addressRequest->input('postal_code'),
            'postal_code' => $profileRequest->input('postal_code'),
            // 'address' => $addressRequest->input('address'),
            'address' => $profileRequest->input('address'),
            // 'building' => $addressRequest->input('building_name'),
            'building' => $profileRequest->input('building_name'),
        ]);

        // プロフィール画面にリダイレクト
        return redirect()->route('profile.show');
    }
}
