<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/items/show.css')); ?>">
</head>

<body>
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <img src="<?php echo e(asset('storage/photos/logo_images/logo.svg')); ?>" alt="COACHTECH ロゴ" class="logo" />
            </div>
            <div class="header-center">
                <form action="<?php echo e(route('items.search')); ?>">
                    <?php echo csrf_field(); ?>
                    <input class="search-bar" type="text" name="item_name" placeholder="なにをお探しですか？" />
                </form>
            </div>
            <div class="header-right">
                <nav class="nav">
                    <ul class="nav__ul">
                        <!-- <li><a href="#" class="nav__left-link">ログアウト</a></li> -->
                        <!-- <li><a href="#" class="nav__center-link">マイページ</a></li>
            <li><a href="#" class="nav__right-link">出品</a></li> -->
                        <li>
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="nav__left-link">
                                    ログアウト
                                </button>
                            </form>
                        </li>
                        <li>
                            <form action="<?php echo e(route('profile.show.sell')); ?>" method="GET">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="nav__center-link">
                                    マイページ
                                </button>
                            </form>
                        </li>
                        <li>
                            <form action="<?php echo e(route('item.store')); ?>" method="GET">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="nav__right-link">出品</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="item-detail">
        
        <img class="item-image" src="<?php echo e(asset('storage/photos/item_images/' . $item->item_image)); ?>" alt="">
        
        <div class="item-info">
            <h1 class="item-title"><?php echo e($item->item_name); ?></h1>
            <p class="item-brand"><?php echo e($item->brand); ?></p>
            <p class="item-price">¥<?php echo e(number_format($item->price)); ?>（税込）</p>
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

                

                
                <?php if(auth()->guard()->check()): ?>
                    <form action="<?php echo e(route('like', ['itemId' => $item->id])); ?>" method="POST">
                        
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="item-reviews__btn">
                            <?php if(auth()->user()->likeItem->contains($item->id)): ?>
                                <!-- いいね済み（黄色の星を表示） -->
                                <img class="item-star" src="<?php echo e(asset('storage/photos/logo_images/star-yellow.png')); ?>"
                                    alt="いいね">
                            <?php else: ?>
                                <!-- いいねしていない（灰色の星を表示） -->
                                <img class="item-star" src="<?php echo e(asset('storage/photos/logo_images/star.png')); ?>"
                                    alt="いいね">
                            <?php endif; ?>
                        </button>
                    </form>
                <?php endif; ?>

                
                <?php if(auth()->guard()->guest()): ?>
                    <img class="item-star" src="<?php echo e(asset('storage/photos/logo_images/star.png')); ?>" alt="いいね">
                <?php endif; ?>

                <img class="item-balloon" src="<?php echo e(asset('storage/photos/logo_images/baloon.png')); ?>" alt="">

                <!-- 「いいね」数表示 -->
                <p class="item-like-count"><?php echo e($item->userLike()->count()); ?></p>
                <!-- 「コメント」数表示 -->
                <p class="item-comment-count"><?php echo e($item->comments->count()); ?></p>
            </div>
            <div class="item-actions">

                
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('item.purchase', ['itemId' => $item->id])); ?>" class="buy-button">購入手続きへ</a>
                <?php endif; ?>

                
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="buy-button">購入手続きへ</a>
                <?php endif; ?>

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
                        
                    </div>
                    <div class="item-description-state">
                        <p><?php echo e($item->description); ?></p>
                    </div>
                </div>
            </section>
            <section class="item-details">
                <h2>商品の情報</h2>
                <div class="item-details-container">
                    <div class="item-details-title">カテゴリー
                    </div>
                    <div class="item-details-category">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><?php echo e($category->category_name); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        
                    </div>
                    <div class="item-details-title">商品の状態</div>
                    <div class="item-details-condition">
                        <p><?php echo e($condition->condition_name); ?></p>
                        
                        
                    </div>
                </div>
            </section>
            <section class="comments">

                <!-- コメント数を表示 -->
                <h2>コメント(<?php echo e($item->comments->count()); ?>)</h2>

                <!-- コメント一覧 -->
                

                
                <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="comment-user">
                        <img class="comment-user-image"
                            src="<?php echo e(asset('storage/photos/profile_images/' . $comment->user->profile_image)); ?>"
                            alt="">
                        <span class="comment-user-name"><?php echo e($comment->user->name); ?></span>
                    </div>
                    <div class="comment-box">
                        <p class="comment-text"><?php echo e($comment->comment); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- コメント投稿フォーム -->
                <form class="comment-form" action="<?php echo e(route('comment', ['itemId' => $item->id])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <label class="comment-textarea__label" for="comment">商品へのコメント</label>
                    
                    <?php if($errors->has('comment')): ?>
                        <div class="error-message">
                            <ul>
                                <?php $__currentLoopData = $errors->get('comment'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <textarea class="comment-textarea" name="comment" id="comment" rows="2" placeholder=""></textarea>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <button type="submit" class="comment-submit">コメントを送信する</button>
                    <?php endif; ?>
                    
                    <?php if(auth()->guard()->guest()): ?>
                        <button class="comment-submit">コメントを送信する</button>
                    <?php endif; ?>
                </form>
            </section>
        </div>
    </main>
</body>

</html>
<?php /**PATH /var/www/resources/views/items/show.blade.php ENDPATH**/ ?>