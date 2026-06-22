<?php
if (!function_exists('__5ae5761a34dbcc0e6c8d7a6e700df8f7')):
function __5ae5761a34dbcc0e6c8d7a6e700df8f7($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/d09e07644b99ad3b6f359d6fdbabcd16.php'); ?>
<?php $__blaze->pushData(['attributes' => $attributes->class('shrink-0'),'variant' => 'subtle','square' => true,'x-data' => true,'x-on:click' => '$dispatch(\'flux-sidebar-toggle\')','aria-label' => ''.e(__('Toggle sidebar')).'','data-flux-sidebar-toggle' => true]); ?>
<?php __d09e07644b99ad3b6f359d6fdbabcd16($__blaze, ['attributes' => $attributes->class('shrink-0'),'variant' => 'subtle','square' => true,'x-data' => true,'x-on:click' => '$dispatch(\'flux-sidebar-toggle\')','aria-label' => ''.e(__('Toggle sidebar')).'','data-flux-sidebar-toggle' => true], [], ['attributes', 'square', 'x-data', 'data-flux-sidebar-toggle'], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/sidebar/toggle.blade.php ENDPATH**/ ?>