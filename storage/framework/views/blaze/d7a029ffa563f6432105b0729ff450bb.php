<?php
if (!function_exists('__d7a029ffa563f6432105b0729ff450bb')):
function __d7a029ffa563f6432105b0729ff450bb($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<nav <?php echo e($attributes->class('flex flex-col overflow-visible min-h-auto')); ?> data-flux-sidebar-nav>
    <?php echo e($slot); ?>

</nav>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/sidebar/nav.blade.php ENDPATH**/ ?>