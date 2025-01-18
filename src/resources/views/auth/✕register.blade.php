@extends('layouts.default')

@section('title', '会員登録')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endpush



@section('content')

      <div class="container-wrap">
      <div class="container">
        <h1 class="title">会員登録</h1>
         <form class="form">
          <div class="form-group">
            <label class="form-group__label" for="username">ユーザー名</label>
            <input
              class="form-group__input"
              type="text"
              id="username"
              name="username"
              required
            />
          </div>
          <div class="form-group">
            <label class="form-group__label" for="email">メールアドレス</label>
            <input
              class="form-group__input"
              type="email"
              id="email"
              name="email"
              required
            />
          </div>
          <div class="form-group">
            <label class="form-group__label" for="password">パスワード</label>
            <input
              class="form-group__input"
              type="password"
              id="password"
              name="password"
              required
            />
          </div>
          <div class="form-group">
            <label class="form-group__label" for="confirm-password"
              >確認用パスワード</label
            >
            <input
              class="form-group__input"
              type="password"
              id="confirm-password"
              name="confirm-password"
              required
            />
          </div>
          <button type="submit" class="form-group__submit-btn">登録する</button>
        </form>
        <p class="login-link">
          <a class="login-link__link-btn" href="login.html">ログインはこちら</a>
        </p>
      </div>
      </div>
   