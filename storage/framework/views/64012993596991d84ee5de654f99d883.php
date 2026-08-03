<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('admin.hero.update')); ?>" enctype="multipart/form-data" class="cms-panel max-w-3xl p-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="space-y-6">

            <div class="grid gap-5">
                <label class="block">
                    <span class="cms-label">Judul Hero</span>
                    <input name="hero_title" value="<?php echo e(old('hero_title', $settings['hero_title'] ?? '')); ?>" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                </label>

                <label class="block">
                    <span class="cms-label">Deskripsi Hero</span>
                    <textarea name="hero_description" rows="4" class="cms-input mt-2 w-full px-3 py-2.5 text-sm resize-y"><?php echo e(old('hero_description', $settings['hero_description'] ?? '')); ?></textarea>
                </label>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <label class="block">
                    <span class="cms-label">Banner Hero</span>
                    <input type="file" name="hero_banner" accept="image/*" class="cms-input mt-2 w-full px-3 py-2.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-slate-200">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($settings['hero_banner'])): ?>
                        <div class="mt-3 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
                            <img src="<?php echo e($settings['hero_banner']); ?>" alt="Hero banner" class="h-48 w-full object-cover">
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </label>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <label class="block">
                    <span class="cms-label">Link Kalender Program</span>
                    <input name="hero_calendar_link" value="<?php echo e(old('hero_calendar_link', $settings['hero_calendar_link'] ?? '/kalender-program')); ?>" placeholder="/kalender-program atau https://..." class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                    <span class="mt-1 block text-xs font-medium text-slate-500">Link ini dipakai oleh tombol Kalender Program di hero halaman utama.</span>
                </label>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <button class="cms-btn cms-btn-primary">
                    Simpan Hero
                </button>
            </div>

        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', ['title' => 'Hero', 'subtitle' => 'Ubah judul, deskripsi, dan banner halaman utama.'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABHINAYA\lerr\manehhh\web-uisi\resources\views/admin/hero.blade.php ENDPATH**/ ?>