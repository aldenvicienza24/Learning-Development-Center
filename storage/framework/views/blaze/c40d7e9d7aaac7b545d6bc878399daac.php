<?php
if (!function_exists('__c40d7e9d7aaac7b545d6bc878399daac')):
function __c40d7e9d7aaac7b545d6bc878399daac($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<?php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-me-1 [[data-flux-input]:has(input:placeholder-shown)_&]:hidden [[data-flux-input]:has(input[disabled])_&]:hidden',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/d09e07644b99ad3b6f359d6fdbabcd16.php'); ?>
<?php if (isset($__slotsd09e07644b99ad3b6f359d6fdbabcd16)) $__slotsOriginal = $__slotsd09e07644b99ad3b6f359d6fdbabcd16; ?>
<?php if (isset($__attrsd09e07644b99ad3b6f359d6fdbabcd16)) $__attrsOriginal = $__attrsd09e07644b99ad3b6f359d6fdbabcd16; ?>
<?php $__attrsd09e07644b99ad3b6f359d6fdbabcd16 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','x-data' => 'fluxInputClearable','x-on:click' => 'clear()','tabindex' => '-1','aria-label' => 'Clear input','data-flux-clear-button' => true]; ?>
<?php $__slotsd09e07644b99ad3b6f359d6fdbabcd16 = []; ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/x-mark.blade.php', $__blaze->compiledPath.'/d50e629d90990bf947a1bd02ab9b4d1c.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro']); ?>
<?php __d50e629d90990bf947a1bd02ab9b4d1c($__blaze, ['variant' => 'micro'], [], [], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsd09e07644b99ad3b6f359d6fdbabcd16['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrsd09e07644b99ad3b6f359d6fdbabcd16); ?>
<?php $__blaze->pushSlots($__slotsd09e07644b99ad3b6f359d6fdbabcd16); ?>
<?php __d09e07644b99ad3b6f359d6fdbabcd16($__blaze, $__attrsd09e07644b99ad3b6f359d6fdbabcd16, $__slotsd09e07644b99ad3b6f359d6fdbabcd16, ['attributes', 'size', 'data-flux-clear-button'], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slotsd09e07644b99ad3b6f359d6fdbabcd16 = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrsd09e07644b99ad3b6f359d6fdbabcd16 = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/input/clearable.blade.php ENDPATH**/ ?>