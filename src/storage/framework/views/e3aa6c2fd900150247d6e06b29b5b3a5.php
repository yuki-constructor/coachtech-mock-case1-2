<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ログイン</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/auth/login.css')); ?>" />
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

                
                <div class="message">
                    <?php if(session()->has('error')): ?>
                        <p><?php echo e(session()->get('error')); ?></p>
                    <?php endif; ?>
                    <?php if(session()->has('login-message')): ?>
                        <p><?php echo e(session()->get('login-message')); ?></p>
                    <?php endif; ?>
                </div>
                

                <h1 class="title">ログイン</h1>
                <form class="form" action="<?php echo e(route('login.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label class="form-group__label" for="email">ユーザー名／メールアドレス</label>
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
                        <input class="form-group__input" type="text" id="email" name="email" />
                    </div>
                    <!-- <div class="form-group">
            <label class="form-group__label" for="email">メールアドレス</label>
            <input
              class="form-group__input"
              type="email"
              id="email"
              name="email"
              required
            />
          </div> -->
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
                    <!-- <div class="form-group">
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
          </div> -->
                    <button type="submit" class="form-group__submit-btn">ログインする</button>
                </form>
                <p class="login-link">
                    <a class="login-link__link-btn" href="<?php echo e(route('register')); ?>">会員登録はこちら</a>
                </p>
            </div>
        </div>
    </main>
</body>

</html>
<?php /**PATH /var/www/resources/views/auth/login.blade.php ENDPATH**/ ?>