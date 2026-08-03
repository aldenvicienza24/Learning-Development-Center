<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" enctype="multipart/form-data" class="cms-panel max-w-4xl p-5">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid gap-5 md:grid-cols-2">
            <label class="block md:col-span-2">
                <span class="cms-label">Logo</span>
                <input type="file" name="logo" accept="image/*" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
            </label>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['email' => 'Email', 'whatsapp' => 'Nomor WhatsApp', 'instagram' => 'Instagram', 'facebook' => 'Facebook', 'youtube' => 'YouTube', 'linkedin' => 'LinkedIn']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <label class="block">
                    <span class="cms-label"><?php echo e($label); ?></span>
                    <input name="<?php echo e($key); ?>" value="<?php echo e(old($key, $settings[$key] ?? '')); ?>" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                </label>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            <label class="block md:col-span-2">
                <span class="cms-label">Alamat</span>
                <textarea name="address" rows="4" class="cms-input mt-2 w-full px-3 py-2.5 text-sm"><?php echo e(old('address', $settings['address'] ?? '')); ?></textarea>
            </label>
        </div>

        <button class="cms-btn cms-btn-primary mt-6">
            Simpan Pengaturan
        </button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', ['title' => 'Pengaturan Website', 'subtitle' => 'Kelola logo, kontak, alamat, dan sosial media.'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABHINAYA\lerr\manehhh\web-uisi\resources\views/admin/settings.blade.php ENDPATH**/ ?>