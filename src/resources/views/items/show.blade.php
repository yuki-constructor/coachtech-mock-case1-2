<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品詳細</title>
  <link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
</head>
<body>
  <header class="header">
    <div class="header-container">
      <div class="header-left">
        <img src="{{asset("storage/photos/logo_images/logo.svg")}}" alt="COACHTECH ロゴ" class="logo" />
      </div>
      <div class="header-center">
        <input type="text" class="search-bar" placeholder="なにをお探しですか？" />
      </div>
      <div class="header-right">
        <nav class="nav">
          <ul class="nav__ul">
            <!-- <li><a href="#" class="nav__left-link">ログアウト</a></li> -->
            <!-- <li><a href="#" class="nav__center-link">マイページ</a></li>
            <li><a href="#" class="nav__right-link">出品</a></li> -->
            <li>
              <form action="{{ route('logout') }}" method="POST">
                 @csrf
                <button type="submit" class="nav__left-link">
                  ログアウト
                </button>
              </form>
            </li>
            <li>
                <form action="{{route('profile.show')}}" method="GET">
                    @csrf
                   <button type="submit" class="nav__center-link">
                     マイページ
                   </button>
                 </form>
            </li>
            <li>
              <form action="{{route('item.store')}}" method="GET">
                 @csrf
                <button type="submit" class="nav__right-link">出品</button>
              </form>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </header>

  <main class="item-detail">
    {{-- <div class="item-image">
      <div class="image-placeholder"> --}}
        <img class="item-image" src="{{asset("storage/photos/item_images/".$item->item_image )}}" alt="">
      {{-- </div>
    </div> --}}
    <div class="item-info">
      <h1 class="item-title">{{$item->item_name}}</h1>
      <p class="item-brand">{{$item->brand}}</p>
      <p class="item-price">¥{{number_format($item->price)}}（税込）</p>
      <!-- <table class="item-reviews">
      <tr>
        <th class="item-star"> &#9734</th>
      <th class="item-balloon"> </th>
    </tr>
    <tr>
      <td>3</td>
      <td>1</td>
    </tr>
      </table> -->
      <div class="item-reviews">
      {{-- <p class="item-star"> &#9734</p> --}}
      <img class="item-star" src="{{asset("storage/photos/logo_images/star.png")}}" alt="">
      {{-- <p class="item-balloon"> </p> --}}
      <img class="item-balloon" src="{{asset("storage/photos/logo_images/baloon.png")}}" alt="">
      <p>3</p>
      <p>1</p>
      </div>
      <div class="item-actions">
        <a href="{{route("item.purchase", ["itemId" => $item->id])}}" class="buy-button">購入手続きへ</a>
        <!-- <button class="buy-button">購入手続きへ</button> -->
      </div>
      <section class="item-description">
        <h2>商品説明</h2>
        <div class="item-description-color">
          <div class="item-description-title">
            カラー：
          </div>
          <div class="item-description-tags">
            <p>グレー</p>
          </div>
        </div>
        <div class="item-description-condition">
          <div class="item-description-title">
            {{-- {{$condition->condition_name}} --}}
          </div>
          <div class="item-description-state">
            <p>{{$item->description}}</p>
          </div>
        </div>
      </section>
      <section class="item-details">
        <h2>商品の情報</h2>
        <div class="item-details-container">
        <div class="item-details-title">カテゴリー
        </div>
        <div class="item-details-category">
            @foreach ($categories as $category)
<p>{{$category->category_name}}</p>
            @endforeach

          {{-- <p>洋服</p>
          <p>メンズ</p>
          <p>洋服</p>
          <p>メンズ</p>
          <p>洋服</p>
          <p>メンズ</p>
          <p>洋服</p>
          <p>メンズ</p> --}}
        </div>
        <div class="item-details-title">商品の状態</div>
        <div class="item-details-condition">
          <p>{{$condition->condition_name}}</p>
          {{-- @foreach ($condition as $condition)
    <p>{{ $condition->condition_name }}</p> --}}
{{-- @endforeach --}}
        </div>
        </div>
      </section>
      <section class="comments">
        <h2>コメント(1)</h2>
        <div class="comment">
          <div class="comment-image-placeholder"></div>
          <span class="user-icon">admin</span>
        </div>
         <div class="comment-box">
        <input type="text" class="comment-input" placeholder="こちらにコメントが入ります。">
      </div>
      <form class="comment-form">
        <label  class="comment-textarea__label" for="">商品へのコメント
        <textarea class="comment-textarea" placeholder=""></textarea></label>
        <button type="submit" class="comment-submit">コメントを送信する</button>
      </form>
    </section>
  </div>
</main>
</body>
</html>


