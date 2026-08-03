<?php $__env->startSection('content'); ?>
    <?php
        $statusLabels = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
        ];
        $paymentLabels = [
            'menunggu_verifikasi' => 'Belum Bayar',
            'disetujui' => 'Lunas',
            'ditolak' => 'Ditolak',
        ];
        $programStatusLabels = [
            'open_registration' => 'Publish',
            'coming_soon' => 'Coming Soon',
            'closed' => 'Ditutup',
        ];
    ?>

    <div id="programPickerPanel" class="cms-panel mb-4 p-5" data-reset-url="<?php echo e($selectedProgram ? route('admin.registrations.index', request()->only(['program_page', 'program_search', 'category', 'program_status'])) : ''); ?>">
        <div class="mb-5 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-slate-950">Daftar Program</h2>
                <p class="mt-1 text-sm font-medium text-slate-500">Pilih program untuk melihat dan mengelola peserta.</p>
            </div>

            <form method="GET" class="grid w-full gap-3 md:grid-cols-[190px_170px] xl:max-w-[373px]">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('program_id')): ?>
                    <input type="hidden" name="program_id" value="<?php echo e(request('program_id')); ?>">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <select name="category" class="cms-input h-11 px-4 text-sm font-bold" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $programCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <option value="<?php echo e($category); ?>" <?php if(request('category') === $category): echo 'selected'; endif; ?>><?php echo e(ucfirst($category)); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>

                <select name="program_status" class="cms-input h-11 px-4 text-sm font-bold" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $programStatusLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <option value="<?php echo e($value); ?>" <?php if(request('program_status') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </form>
        </div>

        <div class="grid grid-cols-4 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $isSelected = (string) request('program_id') === (string) $program->id;
                    $query = $isSelected
                        ? request()->only(['program_page', 'program_search', 'category', 'program_status'])
                        : array_merge(request()->only(['program_page', 'program_search', 'category', 'program_status']), ['program_id' => $program->id]);
                ?>
                <a href="<?php echo e(route('admin.registrations.index', $query)); ?>"
                    class="js-program-card group flex flex-col overflow-hidden rounded-xl border bg-white transition <?php echo e($isSelected ? 'border-[#C3110C] shadow-sm shadow-red-100' : 'border-slate-200 hover:border-red-100 hover:shadow-md hover:shadow-slate-100'); ?>">
                    <div class="flex items-start gap-3 p-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#C3110C]">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5Z"/>
                                <path d="M6 12v5c3 1.5 9 1.5 12 0v-5"/>
                            </svg>
                        </div>
                        <div class="min-w-0 pt-0.5">
                            <p class="line-clamp-1 text-base font-semibold leading-snug text-slate-900"><?php echo e($program->title); ?></p>
                            <p class="mt-1 text-sm font-normal text-slate-500"><?php echo e(ucfirst($program->category)); ?></p>
                        </div>
                    </div>
                    <div class="mt-auto flex items-center justify-between border-t border-slate-100 px-4 py-3">
                        <span class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                            <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-8 0v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <?php echo e($program->registrations_count); ?> Peserta
                        </span>
                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#C3110C]">
                            Lihat Peserta
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                        </span>
                    </div>
                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-span-4 rounded-xl border border-dashed border-slate-300 p-8 text-center text-sm font-semibold text-slate-500">
                    Belum ada program yang sesuai.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($programs->hasPages()): ?>
            <div class="mt-4 flex items-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($programs->onFirstPage()): ?>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-300">&lsaquo;</span>
                <?php else: ?>
                    <a href="<?php echo e($programs->previousPageUrl()); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">&lsaquo;</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($page = 1; $page <= min($programs->lastPage(), 3); $page++): ?>
                    <a href="<?php echo e($programs->url($page)); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-sm font-extrabold <?php echo e($page === $programs->currentPage() ? 'bg-[#C3110C] text-white shadow-sm shadow-red-100' : 'border border-slate-200 text-slate-700 hover:bg-slate-50'); ?>"><?php echo e($page); ?></a>
                <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($programs->lastPage() > 4): ?>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-500">...</span>
                    <a href="<?php echo e($programs->url($programs->lastPage())); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50"><?php echo e($programs->lastPage()); ?></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($programs->hasMorePages()): ?>
                    <a href="<?php echo e($programs->nextPageUrl()); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">&rsaquo;</a>
                <?php else: ?>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-300">&rsaquo;</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $hasActiveFilters): ?>
        <div class="cms-panel p-8 text-center">
            <p class="text-sm font-extrabold text-slate-700">Pilih program untuk melihat data peserta.</p>
            <p class="mt-1 text-sm text-slate-500">Daftar peserta dan bukti pembayaran akan tampil setelah program dipilih.</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedProgram): ?>
        <div class="cms-panel mb-0 overflow-hidden">
            <div class="grid gap-4 border-b border-slate-100 p-4 xl:grid-cols-[minmax(260px,1fr)_repeat(5,minmax(130px,170px))] xl:items-center">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#C3110C]">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5Z"/>
                            <path d="M6 12v5c3 1.5 9 1.5 12 0v-5"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Program Dipilih</p>
                        <div class="mt-1 flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold text-slate-900"><?php echo e($selectedProgram->title); ?></h2>
                            <span class="rounded-md border border-slate-200 bg-slate-50 px-2 py-1 text-xs font-medium text-slate-500"><?php echo e(ucfirst($selectedProgram->category)); ?></span>
                        </div>
                        <p class="mt-2 flex items-center gap-2 text-sm font-normal text-slate-500">
                            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                            <?php echo e($selectedProgram->registration_date); ?>

                        </p>
                    </div>
                </div>

                <div class="rounded-lg bg-slate-50 p-4 text-center">
                    <p class="text-xs font-bold text-slate-400">Total Peserta</p>
                    <p class="mt-1 text-2xl font-extrabold text-slate-950"><?php echo e($selectedProgram->registrations_count); ?></p>
                </div>
                <a href="<?php echo e(route('admin.registrations.index', array_merge(request()->except(['status', 'participant_status', 'page']), ['program_id' => $selectedProgram->id, 'participant_status' => 'menunggu_verifikasi']))); ?>" class="rounded-lg bg-orange-50/60 p-4 text-center">
                    <p class="text-xs font-bold text-orange-500">Menunggu Verifikasi</p>
                    <p class="mt-1 text-2xl font-extrabold text-orange-500"><?php echo e($statusCounts['menunggu_verifikasi'] ?? 0); ?></p>
                </a>
                <a href="<?php echo e(route('admin.registrations.index', array_merge(request()->except(['status', 'participant_status', 'page']), ['program_id' => $selectedProgram->id, 'participant_status' => 'diproses']))); ?>" class="rounded-lg bg-blue-50/60 p-4 text-center">
                    <p class="text-xs font-bold text-blue-500">Diproses</p>
                    <p class="mt-1 text-2xl font-extrabold text-blue-600"><?php echo e($statusCounts['diproses'] ?? 0); ?></p>
                </a>
                <a href="<?php echo e(route('admin.registrations.index', array_merge(request()->except(['status', 'participant_status', 'page']), ['program_id' => $selectedProgram->id, 'participant_status' => 'diterima']))); ?>" class="rounded-lg bg-emerald-50/70 p-4 text-center">
                    <p class="text-xs font-bold text-emerald-600">Diterima</p>
                    <p class="mt-1 text-2xl font-extrabold text-emerald-600"><?php echo e($statusCounts['diterima'] ?? 0); ?></p>
                </a>
                <a href="<?php echo e(route('admin.registrations.index', array_merge(request()->except(['status', 'participant_status', 'page']), ['program_id' => $selectedProgram->id, 'participant_status' => 'ditolak']))); ?>" class="rounded-lg bg-red-50/70 p-4 text-center">
                    <p class="text-xs font-bold text-[#C3110C]">Ditolak</p>
                    <p class="mt-1 text-2xl font-extrabold text-[#C3110C]"><?php echo e($statusCounts['ditolak'] ?? 0); ?></p>
                </a>
            </div>

            <div class="border-b border-slate-100 p-4">
                <form method="GET" class="grid gap-3 xl:grid-cols-[200px_220px_1fr_1fr_auto_auto_auto]">
                    <input type="hidden" name="program_id" value="<?php echo e($selectedProgram->id); ?>">
                    <select name="participant_status" class="cms-input h-10 px-4 text-sm font-bold" onchange="this.form.submit()">
                        <option value="">Status Peserta</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $statusLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <option value="<?php echo e($status); ?>" <?php if($participantStatus === $status): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <select name="payment_status" class="cms-input h-10 px-4 text-sm font-bold" onchange="this.form.submit()">
                        <option value="">Status Pembayaran</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['menunggu_verifikasi' => 'Menunggu Verifikasi', 'disetujui' => 'Lunas', 'ditolak' => 'Ditolak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <option value="<?php echo e($status); ?>" <?php if(request('payment_status') === $status): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" class="cms-input h-10 px-4 text-sm font-semibold text-slate-500">
                    <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" class="cms-input h-10 px-4 text-sm font-semibold text-slate-500">
                    <button class="cms-btn cms-btn-secondary h-10 px-4">Filter</button>
                    <a href="<?php echo e(route('admin.registrations.index', ['program_id' => $selectedProgram->id])); ?>" class="cms-btn cms-btn-secondary h-10 px-4">Reset Filter</a>
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('admin.registrations.export.excel', request()->query())); ?>" class="cms-btn h-10 border border-emerald-500 bg-white px-4 text-emerald-600 hover:bg-emerald-50">Export Excel</a>
                        <a href="<?php echo e(route('admin.registrations.export.pdf', request()->query())); ?>" target="_blank" class="cms-btn h-10 border border-[#C3110C] bg-white px-4 text-[#C3110C] hover:bg-red-50">Export PDF</a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="cms-table w-full min-w-[1180px] text-left text-sm">
                    <thead class="bg-slate-50/70">
                        <tr>
                            <th class="w-12 px-5 py-4">#</th>
                            <th class="px-5 py-4">Nama</th>
                            <th class="px-5 py-4">Kontak</th>
                            <th class="px-5 py-4">Program</th>
                            <th class="px-5 py-4">Bukti</th>
                            <th class="px-5 py-4">Status Peserta</th>
                            <th class="px-5 py-4">Pembayaran</th>
                            <th class="px-5 py-4">Tanggal Daftar</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php
                                $proofUrl = $registration->payment_proof ? asset('storage/'.$registration->payment_proof) : null;
                                $isProofImage = $registration->payment_proof && preg_match('/\.(jpe?g|png|webp|gif)$/i', $registration->payment_proof);
                                $participantValue = $registration->participant_status ?: $registration->status;
                                $paymentValue = $registration->payment_status ?? 'menunggu_verifikasi';
                                $isApproved = $participantValue === 'diterima' && $paymentValue === 'disetujui';
                                $participantBadge = match ($participantValue) {
                                    'diterima' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                    'ditolak' => 'bg-red-50 text-[#C3110C] ring-1 ring-red-200',
                                    'diproses' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                                    default => 'bg-orange-50 text-orange-600 ring-1 ring-orange-200',
                                };
                                $paymentBadge = match ($paymentValue) {
                                    'disetujui' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                    'ditolak' => 'bg-red-50 text-[#C3110C] ring-1 ring-red-200',
                                    default => 'bg-pink-50 text-rose-600 ring-1 ring-pink-200',
                                };
                            ?>
                            <tr class="bg-white">
                                <td class="px-5 py-4 font-bold text-slate-700"><?php echo e($registrations->firstItem() + $loop->index); ?></td>
                                <td class="px-5 py-4">
                                    <p class="font-extrabold text-slate-950"><?php echo e($registration->full_name); ?></p>
                                    <p class="text-xs font-medium text-slate-500"><?php echo e($registration->email); ?></p>
                                </td>
                                <td class="px-5 py-4 font-semibold text-slate-800"><?php echo e($registration->phone); ?></td>
                                <td class="px-5 py-4 font-semibold text-slate-900"><?php echo e($registration->program?->title); ?></td>
                                <td class="px-5 py-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proofUrl): ?>
                                        <a href="<?php echo e($proofUrl); ?>" target="_blank" class="inline-flex items-center gap-2 text-xs font-extrabold text-[#C3110C]">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isProofImage): ?>
                                                <img src="<?php echo e($proofUrl); ?>" alt="Bukti pembayaran <?php echo e($registration->full_name); ?>" class="h-12 w-16 rounded-md border border-slate-200 object-cover">
                                            <?php else: ?>
                                                <span class="inline-flex h-12 w-16 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">PDF</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            Lihat
                                        </a>
                                    <?php else: ?>
                                        <span class="inline-flex h-12 w-16 items-center justify-center rounded-md border border-dashed border-slate-200 bg-slate-50 text-xs font-bold text-slate-400">Kosong</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-md px-3 py-1 text-xs font-extrabold <?php echo e($participantBadge); ?>"><?php echo e($statusLabels[$participantValue] ?? ucfirst(str_replace('_', ' ', $participantValue))); ?></span>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-md px-3 py-1 text-xs font-extrabold <?php echo e($paymentBadge); ?>"><?php echo e($paymentLabels[$paymentValue] ?? ucfirst(str_replace('_', ' ', $paymentValue))); ?></span>
                                </td>
                                <td class="px-5 py-4 font-semibold text-slate-900">
                                    <?php echo e($registration->created_at?->format('d M Y')); ?><br>
                                    <span class="text-xs text-slate-500"><?php echo e($registration->created_at?->format('H:i')); ?></span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $isApproved): ?>
                                            <form method="POST" action="<?php echo e(route('admin.registrations.approve', $registration)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-extrabold text-emerald-700 hover:bg-emerald-100">Setujui</button>
                                            </form>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <a href="<?php echo e(route('admin.registrations.show', $registration)); ?>" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-extrabold text-slate-900 hover:bg-slate-50">Detail</a>
                                        <a href="<?php echo e(route('admin.registrations.edit', $registration)); ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50" aria-label="Edit peserta">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="9" class="px-5 py-10 text-center text-sm font-semibold text-slate-500">
                                    Belum ada peserta yang sesuai dengan filter.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($registrations->hasPages()): ?>
                <div class="flex flex-col gap-3 border-t border-slate-100 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($registrations->onFirstPage()): ?>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-300">&lsaquo;</span>
                        <?php else: ?>
                            <a href="<?php echo e($registrations->previousPageUrl()); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">&lsaquo;</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($page = 1; $page <= min($registrations->lastPage(), 3); $page++): ?>
                            <a href="<?php echo e($registrations->url($page)); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-sm font-extrabold <?php echo e($page === $registrations->currentPage() ? 'bg-[#C3110C] text-white shadow-sm shadow-red-100' : 'border border-slate-200 text-slate-700 hover:bg-slate-50'); ?>"><?php echo e($page); ?></a>
                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($registrations->lastPage() > 4): ?>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-500">...</span>
                            <a href="<?php echo e($registrations->url($registrations->lastPage())); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50"><?php echo e($registrations->lastPage()); ?></a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($registrations->hasMorePages()): ?>
                            <a href="<?php echo e($registrations->nextPageUrl()); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">&rsaquo;</a>
                        <?php else: ?>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-300">&rsaquo;</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-sm font-semibold text-slate-500">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($registrations->total()): ?>
                            <span>Menampilkan <?php echo e($registrations->firstItem()); ?>-<?php echo e($registrations->lastItem()); ?> dari <?php echo e($registrations->total()); ?> data</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <span class="inline-flex h-10 items-center rounded-lg border border-slate-200 px-4">8 per halaman</span>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <script>
        document.addEventListener('click', function (event) {
            const panel = document.getElementById('programPickerPanel');

            if (!panel || !panel.dataset.resetUrl) {
                return;
            }

            const clickedInsidePanel = panel.contains(event.target);
            const clickedProgramCard = event.target.closest('.js-program-card');
            const clickedControl = event.target.closest('a, button, input, select, textarea, label');

            if (clickedInsidePanel && !clickedProgramCard && !clickedControl) {
                window.location.href = panel.dataset.resetUrl;
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', ['title' => 'Peserta', 'subtitle' => 'Kelola peserta, verifikasi pembayaran, dan export data.'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABHINAYA\lerr\manehhh\web-uisi\resources\views/admin/registrations/index.blade.php ENDPATH**/ ?>