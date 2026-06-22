<?php if (! $__env->hasRenderedOnce('fb6e5542-3986-480a-a3f5-66e5a972c5f8')): $__env->markAsRenderedOnce('fb6e5542-3986-480a-a3f5-66e5a972c5f8'); ?>
<style>
    @keyframes facultyCardEnter {
        from { opacity: 0; transform: translateY(18px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .faculty-section-card {
        animation: facultyCardEnter 520ms cubic-bezier(0.22, 1, 0.36, 1) both;
        transition: transform 220ms cubic-bezier(0.22, 1, 0.36, 1), box-shadow 220ms ease, background-color 220ms ease;
    }

    .faculty-section-card:nth-child(2) { animation-delay: 90ms; }
    .faculty-section-card:nth-child(3) { animation-delay: 180ms; }
    .faculty-section-card:nth-child(4) { animation-delay: 270ms; }

    .faculty-section-card::before {
        content: '';
        position: absolute;
        inset: 0 0 auto 0;
        height: 4px;
        background: linear-gradient(90deg, #740A03, #C3110C);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 220ms ease;
    }

    .faculty-section-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 24px 44px -20px rgba(40, 12, 12, 0.45);
    }

    .faculty-section-card:hover::before { transform: scaleX(1); }

    .faculty-section-card-icon,
    .faculty-section-card-arrow,
    .faculty-section-chip {
        transition: transform 220ms cubic-bezier(0.22, 1, 0.36, 1), background-color 220ms ease, color 220ms ease, box-shadow 220ms ease;
    }

    .faculty-section-card:hover .faculty-section-card-icon {
        transform: translateY(-2px) scale(1.06) rotate(-2deg);
        box-shadow: 0 14px 28px -14px rgba(195, 17, 12, 0.9);
    }

    .faculty-section-card:hover .faculty-section-card-arrow { transform: translateX(4px); }

    .faculty-section-card:hover .faculty-section-chip {
        background: #FEF2F2;
        color: #7F1D1D;
        transform: translateX(2px);
    }

    @media (max-width: 768px) {
        .faculty-cards-section {
            padding-left: 35px !important;
            padding-right: 35px !important;
        }

        .faculty-cards-section-inner {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    }

    @media (min-width: 769px) {
        .faculty-cards-section {
            padding-left: 60px !important;
            padding-right: 60px !important;
        }

        .faculty-cards-section-inner {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    }
</style>
<?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($faculties)): ?>
<section class="faculty-cards-section mobile-x-20 relative overflow-hidden py-16 md:py-20 mt-16" style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%);">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
        <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1400px] md:h-[1400px] bg-white rounded-full" style="opacity: 0.02;"></div>
        <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[680px] h-[680px] md:w-[1200px] md:h-[1200px] bg-white rounded-full" style="opacity: 0.03; animation-delay: 0.4s;"></div>
        <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[560px] h-[560px] md:w-[1000px] md:h-[1000px] bg-white rounded-full" style="opacity: 0.04; animation-delay: 0.8s;"></div>
        <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[440px] h-[440px] md:w-[800px] md:h-[800px] bg-white rounded-full" style="opacity: 0.05; animation-delay: 1.2s;"></div>
    </div>

    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

    <div class="faculty-cards-section-inner relative z-10 max-w-7xl mx-auto">
        <div class="reveal text-center mb-12">
            <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold tracking-widest uppercase mb-4 backdrop-blur-sm">Eksplorasi</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight drop-shadow-md">Program Bidang Studi</h2>
            <p class="text-white/80 text-sm md:text-base max-w-2xl mx-auto font-medium">Pilih program berdasarkan bidang yang paling sesuai dengan kebutuhan belajar dan kariermu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 md:gap-8">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <a href="<?php echo e(route('faculty.show', $faculty['slug'])); ?>"
               class="faculty-section-card group flex flex-col p-6 md:p-7 bg-white rounded-[20px] shadow-lg h-full relative overflow-hidden ring-1 ring-black/5">
                <div class="flex items-center justify-between mb-6">
                    <div class="faculty-section-card-icon w-12 h-12 rounded-xl bg-gradient-to-br from-[#740A03] to-[#C3110C] shadow-sm flex items-center justify-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($faculty['icon'] === 'finance'): ?>
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <?php elseif($faculty['icon'] === 'industry'): ?>
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <?php elseif($faculty['icon'] === 'language'): ?>
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                        <?php else: ?>
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1.5 text-xs font-extrabold text-[#C3110C]"><?php echo e($faculty['program_count']); ?> Program</span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 text-gray-500 font-bold text-[10px] uppercase tracking-widest border border-gray-200"><?php echo e($faculty['code']); ?></span>
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-[#C3110C] transition-colors duration-300 tracking-tight"><?php echo e($faculty['name']); ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2"><?php echo e($faculty['subtitle']); ?></p>
                </div>

                <div class="flex flex-wrap gap-2 mb-7 flex-grow">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $faculty['classes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <span class="faculty-section-chip inline-flex items-center rounded-full bg-gray-50 px-3 py-1.5 text-[12px] font-semibold leading-tight text-gray-600"><?php echo e($class); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                <div class="mt-auto">
                    <div class="flex items-center justify-between rounded-xl bg-[#FAFAFA] px-4 py-3 text-sm font-extrabold text-[#C3110C] group-hover:bg-red-50">
                        <span>Jelajahi Program</span>
                        <svg class="faculty-section-card-arrow w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\PROJECT\web-uisi\resources\views/partials/faculty-cards-section.blade.php ENDPATH**/ ?>