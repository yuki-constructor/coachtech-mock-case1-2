<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>プロフィール</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/profile/show-sell.css')); ?>" />
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
        <div class="form-group">
            <div class="user-profile">
                <div class="user-profile-image-placeholder">
                    <img class="user-profile-image"
                        src="<?php echo e(asset('storage/photos/profile_images/' . $user->profile_image)); ?>" alt="">
                </div>
                <p><?php echo e($user->name); ?></p>
                <a href="<?php echo e(route('profile.edit')); ?>" class="user-profile-edit__btn">プロフィールを編集</a>
            </div>
        </div>
        <div class="menu">
            <a href="#" class="menu__left-link">出品した商品</a>
            <a href="<?php echo e(route('profile.show.buy')); ?>" class="menu__right-link">購入した商品</a>
        </div>
        <div class="item-list">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <img class="item-image" src="<?php echo e(asset('storage/photos/item_images/' . $item->item_image)); ?>"
                        alt="">
                    <div class="item-name"><?php echo e($item->item_name); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
        </div>
    </main>
</body>

</html>
<?php /**PATH /var/www/resources/views/profile/show-sell.blade.php ENDPATH**/ ?>