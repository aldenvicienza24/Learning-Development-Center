<?php
if (!function_exists('__247d39d9e0bf8a11d1234c344e99c84a')):
function __247d39d9e0bf8a11d1234c344e99c84a($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<div <?php echo e($attributes->class('flex items-center justify-between gap-2 min-h-10')); ?> data-flux-sidebar-header>
    <?php echo e($slot); ?>

</div><?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/sidebar/header.blade.php ENDPATH**/ ?>