<?php if (isset($component)) { $__componentOriginal08b8a564843783787e0bee3357e24f38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal08b8a564843783787e0bee3357e24f38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::auth','data' => ['title' => __('Login CMS')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Login CMS'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <style>
        .cms-login-card {
            width: 100%;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 18px 48px rgba(15, 23, 42, 0.14);
        }

        .cms-login-header {
            padding: 28px;
            background: #101827;
            color: #ffffff;
        }

        .cms-login-kicker {
            margin: 0;
            color: #fecaca;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .cms-login-title {
            margin: 8px 0 0;
            font-size: 28px;
            line-height: 1.15;
            font-weight: 900;
            letter-spacing: 0;
        }

        .cms-login-copy {
            margin: 12px 0 0;
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.7;
        }

        .cms-login-body {
            padding: 28px;
        }

        .cms-login-form {
            display: grid;
            gap: 18px;
        }

        .cms-login-field {
            display: grid;
            gap: 8px;
        }

        .cms-login-label {
            color: #0f172a;
            font-size: 13px;
            font-weight: 800;
        }

        .cms-login-input {
            width: 100%;
            min-height: 46px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            color: #0f172a;
            padding: 0 14px;
            font-size: 14px;
            outline: none;
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }

        .cms-login-input:focus {
            border-color: #c3110c;
            box-shadow: 0 0 0 3px rgba(195, 17, 12, 0.14);
        }

        .cms-login-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .cms-login-check {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
        }

        .cms-login-link {
            color: #c3110c;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
        }

        .cms-login-link:hover {
            text-decoration: underline;
        }

        .cms-login-button {
            width: 100%;
            min-height: 48px;
            border: 0;
            border-radius: 8px;
            background: #c3110c;
            color: #ffffff;
            cursor: pointer;
            font-size: 14px;
            font-weight: 900;
            transition: background 150ms ease, transform 150ms ease;
        }

        .cms-login-button:hover {
            background: #9f0e0a;
            transform: translateY(-1px);
        }

        .cms-login-error {
            color: #b91c1c;
            font-size: 12px;
            font-weight: 700;
        }

        @media (max-width: 480px) {
            .cms-login-header,
            .cms-login-body {
                padding: 22px;
            }

            .cms-login-title {
                font-size: 24px;
            }
        }
    </style>

    <section class="cms-login-card" aria-label="Login CMS UISI">
        <header class="cms-login-header">
            <p class="cms-login-kicker">UISI CMS</p>
            <h1 class="cms-login-title">Masuk Admin</h1>
            <p class="cms-login-copy">Kelola hero, program, peserta, dan pengaturan website melalui panel CMS.</p>
        </header>

        <div class="cms-login-body">
            <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'mb-4 text-center','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4 text-center','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $attributes = $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $component = $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.store')); ?>" class="cms-login-form">
                <?php echo csrf_field(); ?>

                <label class="cms-login-field">
                    <span class="cms-login-label">Masukkan email kamu</span>
                    <input
                        class="cms-login-input"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="Masukkan email kamu"
                    >
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="cms-login-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </label>

                <label class="cms-login-field">
                    <span class="cms-login-label">Password admin</span>
                    <input
                        class="cms-login-input"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan password"
                    >
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="cms-login-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </label>

                <div class="cms-login-row">
                    <label class="cms-login-check">
                        <input name="remember" type="checkbox" <?php if(old('remember')): echo 'checked'; endif; ?>>
                        <span>Ingat perangkat ini</span>
                    </label>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('password.request')): ?>
                        <a class="cms-login-link" href="<?php echo e(route('password.request')); ?>">Lupa password?</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <button type="submit" class="cms-login-button" data-test="login-button">
                    Masuk ke CMS
                </button>
            </form>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal08b8a564843783787e0bee3357e24f38)): ?>
<?php $attributes = $__attributesOriginal08b8a564843783787e0bee3357e24f38; ?>
<?php unset($__attributesOriginal08b8a564843783787e0bee3357e24f38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal08b8a564843783787e0bee3357e24f38)): ?>
<?php $component = $__componentOriginal08b8a564843783787e0bee3357e24f38; ?>
<?php unset($__componentOriginal08b8a564843783787e0bee3357e24f38); ?>
<?php endif; ?>
<?php /**PATH C:\Users\ABHINAYA\lerr\manehhh\web-uisi\resources\views/pages/auth/login.blade.php ENDPATH**/ ?>