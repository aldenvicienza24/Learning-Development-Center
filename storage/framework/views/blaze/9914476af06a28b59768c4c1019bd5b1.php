<?php
if (!function_exists('__9914476af06a28b59768c4c1019bd5b1')):
function __9914476af06a28b59768c4c1019bd5b1($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
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
<?php $__attrsd09e07644b99ad3b6f359d6fdbabcd16 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','x-data' => 'fluxInputCopyable','x-on:click' => 'copy()','x-bind:data-copyable-copied' => 'copied','aria-label' => ''.e(__('Copy to clipboard')).'']; ?>
<?php $__slotsd09e07644b99ad3b6f359d6fdbabcd16 = []; ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/clipboard-document-check.blade.php', $__blaze->compiledPath.'/76e3690d12b29424e5d81124ed3ec590.php'); ?>
<?php $__blaze->pushData(['variant' => 'mini','class' => 'hidden [[data-copyable-copied]>&]:block']); ?>
<?php __76e3690d12b29424e5d81124ed3ec590($__blaze, ['variant' => 'mini','class' => 'hidden [[data-copyable-copied]>&]:block'], [], [], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/clipboard-document.blade.php', $__blaze->compiledPath.'/e692d4ef033e69a242c4fd9be01038ab.php'); ?>
<?php $__blaze->pushData(['variant' => 'mini','class' => 'block [[data-copyable-copied]>&]:hidden']); ?>
<?php __e692d4ef033e69a242c4fd9be01038ab($__blaze, ['variant' => 'mini','class' => 'block [[data-copyable-copied]>&]:hidden'], [], [], isset($this) ? $this : null); ?>
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
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/input/copyable.blade.php ENDPATH**/ ?>