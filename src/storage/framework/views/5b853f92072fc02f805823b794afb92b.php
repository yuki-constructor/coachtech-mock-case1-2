<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>商品一覧</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/items/index.css')); ?>" />
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

    <main>
        <div class="menu">
            <a href="#" class="menu__left-link">おすすめ</a>
            
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('items.index.mylist')); ?>" class="menu__right-link">マイリスト</a>
            <?php endif; ?>
            
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('items.index.mylist')); ?>" class="menu__right-link">マイリスト</a>
            <?php endif; ?>
        </div>

        
        <div class="item-list">
            

            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($item->purchases()->exists()): ?>
                    <div class="item">
                        <img class="item-sold-image"
                            src="<?php echo e(asset('storage/photos/item_images/' . $item->item_image)); ?>" alt="">
                        <div class="item-sold-name">
                            <p>SOLD <?php echo e($item->item_name); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('item.show', ['itemId' => $item->id])); ?>">
                        <div class="item">
                            <img class="item-image"
                                src="<?php echo e(asset('storage/photos/item_images/' . $item->item_image)); ?>" alt="">
                            <div class="item-name">
                                <p><?php echo e($item->item_name); ?></p>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
        </div>
    </main>

</body>

</html>
<?php /**PATH /var/www/resources/views/items/index.blade.php ENDPATH**/ ?>