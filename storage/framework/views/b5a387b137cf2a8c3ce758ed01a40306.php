<?php $__env->startSection('content'); ?>
    <div class="cms-panel mb-4 p-3">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" action="<?php echo e(route('admin.programs.index')); ?>" class="flex flex-wrap gap-2">
                <select name="category" class="cms-input px-3 py-2 text-sm font-normal" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <option value="<?php echo e($value); ?>" <?php if(strtolower((string) request('category')) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <select name="status" class="cms-input px-3 py-2 text-sm font-normal" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="coming_soon" <?php if(request('status') === 'coming_soon'): echo 'selected'; endif; ?>>Coming Soon</option>
                    <option value="open_registration" <?php if(request('status') === 'open_registration'): echo 'selected'; endif; ?>>Publish</option>
                    <option value="closed" <?php if(request('status') === 'closed'): echo 'selected'; endif; ?>>Ditutup</option>
                </select>
                <select name="type" class="cms-input px-3 py-2 text-sm font-normal" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    <option value="nasional" <?php if(request('type') === 'nasional'): echo 'selected'; endif; ?>>Nasional</option>
                    <option value="internasional" <?php if(request('type') === 'internasional'): echo 'selected'; endif; ?>>Internasional</option>
                </select>
                <button class="cms-btn cms-btn-secondary text-sm font-medium">Filter</button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->filled('category') || request()->filled('status') || request()->filled('type')): ?>
                    <a href="<?php echo e(route('admin.programs.index')); ?>" class="cms-btn cms-btn-secondary text-sm font-medium">Reset</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </form>

            <a href="<?php echo e(route('admin.programs.create')); ?>" class="cms-btn cms-btn-primary text-sm font-semibold">
                + Tambah Program
            </a>
        </div>
    </div>

    <div class="cms-panel overflow-hidden">
        <table class="cms-table w-full min-w-[900px] text-left text-sm">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Program</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Kategori</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Status</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Kuota</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Tanggal</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php
                        $statusLabels = [
                            'coming_soon'       => 'Coming Soon',
                            'open_registration' => 'Publish',
                            'closed'            => 'Ditutup',
                        ];

                        $statusClass = match ($program->computed_status) {
                            'open_registration' => 'bg-green-50 text-green-700',
                            'closed'            => 'bg-slate-100 text-slate-600',
                            default             => 'bg-yellow-50 text-yellow-700',
                        };
                    ?>
                    <tr class="hover:bg-slate-50/50">
                        
                        <td class="px-5 py-4">
                            <p class="text-sm font-semibold text-slate-900"><?php echo e($program->title); ?></p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">
                                <?php echo e($program->registration_date); ?> &middot; <?php echo e($program->detail_url); ?>

                            </p>
                        </td>

                        
                        <td class="px-5 py-4 text-sm font-normal text-slate-700">
                            <div><?php echo e(ucfirst($program->category)); ?></div>
                            <div class="mt-0.5 text-xs text-slate-400">
                                <?php echo e($program->is_international ? 'Internasional' : 'Nasional'); ?>

                            </div>
                        </td>

                        
                        <td class="px-5 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold <?php echo e($statusClass); ?>">
                                <?php echo e($statusLabels[$program->computed_status] ?? ucfirst(str_replace('_', ' ', $program->computed_status))); ?>

                            </span>
                        </td>

                        
                        <td class="px-5 py-4">
                            <p class="text-sm font-normal text-slate-700"><?php echo e($program->total_quota ?: $program->quota); ?> awal</p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">
                                <?php echo e($program->registered_count); ?> peserta, <?php echo e($program->remaining_quota); ?> sisa
                            </p>
                        </td>

                        
                        <td class="px-5 py-4">
                            <p class="text-sm font-normal text-slate-700"><?php echo e($program->registration_date); ?></p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">
                                <?php echo e($program->event_date?->format('d M Y') ?? '-'); ?>

                            </p>
                        </td>

                        
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route('admin.programs.edit', $program)); ?>"
                                   class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    Edit
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.programs.destroy', $program)); ?>"
                                      onsubmit="return confirm('Hapus program ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-sm font-normal text-slate-400">
                            Belum ada program.
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        <?php echo e($programs->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', ['title' => 'Program', 'subtitle' => 'Kelola data utama program dari satu tempat.'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABHINAYA\lerr\manehhh\web-uisi\resources\views/admin/programs/index.blade.php ENDPATH**/ ?>