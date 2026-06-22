<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($faculty['name']); ?> - UISI Pusat Layanan</title>
    <link rel="icon" href="/favicon.svg?v=<?php echo e(time()); ?>" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #790B06;
            --primary-light: #C3110C;
        }
        body { font-family: "Inter", sans-serif; overflow-x: hidden; background-color: #FAFAFA; }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        }
    </style>
    <?php echo $__env->make('partials.navbar-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="min-h-screen flex flex-col">
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php
        $categoryLabels = ['pelatihan' => 'Pelatihan', 'sertifikasi' => 'Sertifikasi', 'bahasa' => 'Bahasa'];
        $categoryGroups = collect($categoryLabels)
            ->map(fn($label, $key) => [
                'key' => $key,
                'label' => $label,
                'programs' => $programs->filter(fn($program) => strtolower($program->category) === $key)->values(),
            ])
            ->filter(fn($group) => $group['programs']->isNotEmpty())
            ->values();
        $firstProgram = $programs->first();
    ?>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="mobile-x-20 relative pt-8 pb-16 px-4 md:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="relative overflow-hidden rounded-[2rem] shadow-2xl bg-gray-900 min-h-[480px] flex items-center">
                    <img src="<?php echo e($firstProgram?->image_url ?? asset('images/hero-bg.jpg')); ?>" alt="<?php echo e($faculty['name']); ?>"
                        class="absolute inset-0 h-full w-full object-cover opacity-40 mix-blend-overlay"
                        onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1600&q=80';">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#4A0404]/95 via-[#790B06]/80 to-transparent"></div>
                    
                    <div class="relative z-10 w-full px-5 md:px-16 py-12 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-8 text-left">
                            <a href="<?php echo e(route('dashboard')); ?>#fakultasKelas"
                                class="inline-flex items-center gap-2 text-sm font-medium text-white/80 hover:text-white transition-colors mb-8 bg-white/10 hover:bg-white/20 px-5 py-2.5 rounded-full backdrop-blur-sm border border-white/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Dashboard
                            </a>

                            <div class="flex flex-wrap items-center gap-3 mb-6">
                                <span class="px-4 py-1.5 bg-[#C3110C] text-white text-sm font-bold tracking-wider rounded-lg shadow-lg">
                                    <?php echo e($faculty['code']); ?>

                                </span>
                                <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md border border-white/30 text-white text-sm font-medium rounded-lg">
                                    <?php echo e($programs->count()); ?> Program Tersedia
                                </span>
                            </div>

                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6 drop-shadow-lg">
                                <?php echo e($faculty['name']); ?>

                            </h1>
                            <p class="text-lg md:text-xl text-white/90 max-w-2xl font-light leading-relaxed">
                                <?php echo e($faculty['subtitle']); ?>

                            </p>
                        </div>

                        <div class="lg:col-span-4 hidden lg:block">
                            <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 shadow-2xl transform hover:-translate-y-1 transition duration-300">
                                <h3 class="text-sm font-bold uppercase tracking-widest text-white/80 mb-5 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Fokus Materi
                                </h3>
                                <ul class="space-y-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $faculty['classes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <li class="flex items-center gap-3 text-white">
                                            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0 border border-white/10">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <span class="font-medium text-sm"><?php echo e($class); ?></span>
                                        </li>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 -mt-10 relative z-20 px-5 md:px-12">
                    <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex items-center gap-4 transform hover:-translate-y-1 transition duration-300">
                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm font-bold text-gray-500 uppercase tracking-wide">Total</p>
                            <p class="text-2xl md:text-3xl font-black text-gray-900 leading-none mt-1"><?php echo e($programs->count()); ?></p>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categoryLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex items-center gap-4 transform hover:-translate-y-1 transition duration-300">
                            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($key == 'pelatihan'): ?>
                                    <svg class="w-6 h-6 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <?php elseif($key == 'sertifikasi'): ?>
                                    <svg class="w-6 h-6 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div>
                                <p class="text-xs md:text-sm font-bold text-gray-500 uppercase tracking-wide"><?php echo e($label); ?></p>
                                <p class="text-2xl md:text-3xl font-black text-gray-900 leading-none mt-1"><?php echo e($programs->filter(fn($program) => strtolower($program->category) === $key)->count()); ?></p>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Main Content Grid -->
        <section class="mobile-x-20 px-4 md:px-8 py-8 md:py-12">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Sidebar -->
                <aside class="lg:col-span-3">
                    <div class="sticky top-24 space-y-6">
                        <div class="glass-card rounded-3xl p-7 border border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Tentang Bidang Ini</h2>
                            <p class="text-gray-600 text-sm leading-relaxed mb-6"><?php echo e($faculty['about']); ?></p>
                            
                            <hr class="border-gray-100 mb-6">
                            
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Pilih Bidang Lain</h3>
                            <div class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <a href="<?php echo e(route('faculty.show', $item['slug'])); ?>"
                                        class="group flex items-center justify-between p-3 rounded-xl transition-all duration-200 <?php echo e($item['slug'] === $faculty['slug'] ? 'bg-[#C3110C] shadow-md' : 'hover:bg-red-50 border border-transparent hover:border-red-100'); ?>">
                                        <span class="text-sm font-semibold <?php echo e($item['slug'] === $faculty['slug'] ? 'text-white' : 'text-gray-700 group-hover:text-[#C3110C]'); ?>"><?php echo e($item['name']); ?></span>
                                        <span class="text-xs py-1 px-2 rounded-md font-bold <?php echo e($item['slug'] === $faculty['slug'] ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500 group-hover:bg-red-100 group-hover:text-[#C3110C]'); ?>"><?php echo e($item['program_count']); ?></span>
                                    </a>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Programs -->
                <div class="lg:col-span-9 space-y-12">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
                        <div>
                            <p class="text-[#C3110C] font-bold tracking-wider text-sm mb-2">PILIHAN KELAS</p>
                            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Program Tersedia</h2>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categoryGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <a href="#<?php echo e($group['key']); ?>"
                                    class="px-5 py-2.5 bg-white border border-gray-200 text-sm font-bold text-gray-600 hover:border-[#C3110C] hover:text-[#C3110C] hover:shadow-md transition-all rounded-full">
                                    <?php echo e($group['label']); ?>

                                </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($programs->isEmpty()): ?>
                        <div class="glass-card rounded-3xl p-16 text-center border border-gray-100 flex flex-col items-center justify-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada program</h3>
                            <p class="text-gray-500 max-w-md mx-auto">Program akan muncul otomatis setelah data pelatihan, sertifikasi, atau bahasa ditambahkan oleh admin.</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-16">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categoryGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <div id="<?php echo e($group['key']); ?>" class="scroll-mt-32">
                                    <div class="flex items-center gap-4 mb-8">
                                        <h3 class="text-2xl font-bold text-gray-900"><?php echo e($group['label']); ?></h3>
                                        <div class="flex-grow h-px bg-gray-200"></div>
                                        <span class="text-sm font-medium text-gray-500"><?php echo e($group['programs']->count()); ?> program</span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $group['programs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginald9310f761ca3b505bd202bc791893352 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9310f761ca3b505bd202bc791893352 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.program-card','data' => ['program' => $program]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('program-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['program' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($program)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9310f761ca3b505bd202bc791893352)): ?>
<?php $attributes = $__attributesOriginald9310f761ca3b505bd202bc791893352; ?>
<?php unset($__attributesOriginald9310f761ca3b505bd202bc791893352); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9310f761ca3b505bd202bc791893352)): ?>
<?php $component = $__componentOriginald9310f761ca3b505bd202bc791893352; ?>
<?php unset($__componentOriginald9310f761ca3b505bd202bc791893352); ?>
<?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <?php echo $__env->make('partials.navbar-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html>
<?php /**PATH C:\PROJECT\web-uisi\resources\views/faculty.blade.php ENDPATH**/ ?>