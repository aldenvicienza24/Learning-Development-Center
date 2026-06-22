<?php
if (!function_exists('__f4965c742d257586cfbc3cd81baf268d')):
function __f4965c742d257586cfbc3cd81baf268d($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
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
    'class' => '-me-1',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/d09e07644b99ad3b6f359d6fdbabcd16.php'); ?>
<?php if (isset($__slotsd09e07644b99ad3b6f359d6fdbabcd16)) $__slotsOriginal = $__slotsd09e07644b99ad3b6f359d6fdbabcd16; ?>
<?php if (isset($__attrsd09e07644b99ad3b6f359d6fdbabcd16)) $__attrsOriginal = $__attrsd09e07644b99ad3b6f359d6fdbabcd16; ?>
<?php $__attrsd09e07644b99ad3b6f359d6fdbabcd16 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','x-data' => 'fluxInputViewable','x-on:click' => 'toggle()','x-bind:data-viewable-open' => 'open','aria-label' => ''.e(__('Toggle password visibility')).'']; ?>
<?php $__slotsd09e07644b99ad3b6f359d6fdbabcd16 = []; ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/eye-slash.blade.php', $__blaze->compiledPath.'/a5c6e6aeb9be0440e50566b928b6fef5.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro','class' => 'hidden [[data-viewable-open]>&]:block']); ?>
<?php __a5c6e6aeb9be0440e50566b928b6fef5($__blaze, ['variant' => 'micro','class' => 'hidden [[data-viewable-open]>&]:block'], [], [], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/eye.blade.php', $__blaze->compiledPath.'/27c42304b2337d8381c0b1dc39ea5ff5.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro','class' => 'block [[data-viewable-open]>&]:hidden']); ?>
<?php __27c42304b2337d8381c0b1dc39ea5ff5($__blaze, ['variant' => 'micro','class' => 'block [[data-viewable-open]>&]:hidden'], [], [], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsd09e07644b99ad3b6f359d6fdbabcd16['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrsd09e07644b99ad3b6f359d6fdbabcd16); ?>
<?php $__blaze->pushSlots($__slotsd09e07644b99ad3b6f359d6fdbabcd16); ?>
<?php __d09e07644b99ad3b6f359d6fdbabcd16($__blaze, $__attrsd09e07644b99ad3b6f359d6fdbabcd16, $__slotsd09e07644b99ad3b6f359d6fdbabcd16, ['attributes', 'size'], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slotsd09e07644b99ad3b6f359d6fdbabcd16 = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrsd09e07644b99ad3b6f359d6fdbabcd16 = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/input/viewable.blade.php ENDPATH**/ ?>