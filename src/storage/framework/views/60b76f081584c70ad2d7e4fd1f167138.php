<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>会員登録</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/auth/register.css')); ?>" />
</head>

<body>
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <img src="<?php echo e(asset('storage/photos/logo_images/logo.svg')); ?>" alt="COACHTECH ロゴ" class="logo" />
            </div>
            <div class="header-center">

            </div>
            <div class="header-right">

            </div>
        </div>
    </header>

    <main>
        <div class="container-wrap">
            <div class="container">
                <h1 class="title">会員登録</h1>
                <form class="form" action="<?php echo e(route('user.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label class="form-group__label" for="name">ユーザー名</label>
                        <div>
                            
                            <?php if($errors->has('name')): ?>
                                <div class="error-message">
                                    <ul>
                                        <?php $__currentLoopData = $errors->get('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input class="form-group__input" type="text" id="name" name="name"
                            value="<?php echo e(old('name')); ?>" />
                    </div>
                    <div class="form-group">
                        <label class="form-group__label" for="email">メールアドレス</label>
                        <div>
                            
                            <?php if($errors->has('email')): ?>
                                <div class="error-message">
                                    <ul>
                                        <?php $__currentLoopData = $errors->get('email'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input class="form-group__input"  id="email" name="email"
                            value="<?php echo e(old('email')); ?>" />
                    </div>
                    <div class="form-group">
                        <label class="form-group__label" for="password">パスワード</label>
                        <div>
                            
                            <?php if($errors->has('password')): ?>
                                <div class="error-message">
                                    <ul>
                                        <?php $__currentLoopData = $errors->get('password'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input class="form-group__input" type="password" id="password" name="password" />
                    </div>
                    <div class="form-group">
                        <label class="form-group__label" for="confirm-password">確認用パスワード</label>
                        <div>
                            
                            <?php if($errors->has('password_confirmation')): ?>
                                <div class="error-message">
                                    <ul>
                                        <?php $__currentLoopData = $errors->get('password_confirmation'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input class="form-group__input" type="password" id="password_confirmation"
                            name="password_confirmation" />
                    </div>
                    
                    <button type="submit" class="form-group__submit-btn">登録する</button>
                </form>
                <p class="login-link">
                    <a class="login-link__link-btn" href="<?php echo e(route('login')); ?>">ログインはこちら</a>
                </p>
            </div>
        </div>
    </main>
</body>

</html>
<?php /**PATH /var/www/resources/views/auth/register.blade.php ENDPATH**/ ?>