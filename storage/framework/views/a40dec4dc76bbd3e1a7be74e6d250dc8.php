<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <style>
            .auth-cms-page {
                min-height: 100vh;
                margin: 0;
                background: #f6f7fb;
                color: #0f172a;
                font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
            }

            .auth-cms-wrap {
                box-sizing: border-box;
                display: flex;
                min-height: 100vh;
                align-items: center;
                justify-content: center;
                padding: 32px 16px;
            }

            .auth-cms-stack {
                width: 100%;
                max-width: 440px;
            }

            .auth-cms-brand {
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
                text-decoration: none;
            }

            .auth-cms-brand img {
                display: block;
                height: 48px;
                width: auto;
            }
        </style>
    </head>
    <body class="auth-cms-page">
        <div class="auth-cms-wrap">
            <div class="auth-cms-stack">
                <a href="<?php echo e(route('home')); ?>" class="auth-cms-brand" wire:navigate>
                    <img src="<?php echo e(asset('images/LogoUISI.png')); ?>" alt="Logo UISI" class="h-11 w-auto">
                    <span class="sr-only"><?php echo e(config('app.name', 'Laravel')); ?></span>
                </a>
                <?php echo e($slot); ?>

            </div>
        </div>
        <?php app('livewire')->forceAssetInjection(); ?>
<?php echo app('flux')->scripts(); ?>

    </body>
</html>
<?php /**PATH C:\Users\ABHINAYA\lerr\manehhh\web-uisi\resources\views/layouts/auth/simple.blade.php ENDPATH**/ ?>