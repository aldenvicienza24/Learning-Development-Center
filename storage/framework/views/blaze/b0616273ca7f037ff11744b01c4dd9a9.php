<?php
if (!function_exists('__b0616273ca7f037ff11744b01c4dd9a9')):
function __b0616273ca7f037ff11744b01c4dd9a9($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<?php
$__defaults = [
    'name' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
unset($__defaults);
?>

<?php
// We only want to show the name attribute on the checkbox if it has been set
// manually, but not if it has been set from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    ->add('flex size-[1.125rem] rounded-[.3rem] mt-px outline-offset-2')
    ;
?>

<?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/with-inline-field.blade.php', $__blaze->compiledPath.'/1c2994ef08fa326e570a3e2362f1a0aa.php'); ?>
<?php if (isset($__slots1c2994ef08fa326e570a3e2362f1a0aa)) $__slotsOriginal = $__slots1c2994ef08fa326e570a3e2362f1a0aa; ?>
<?php if (isset($__attrs1c2994ef08fa326e570a3e2362f1a0aa)) $__attrsOriginal = $__attrs1c2994ef08fa326e570a3e2362f1a0aa; ?>
<?php $__attrs1c2994ef08fa326e570a3e2362f1a0aa = ['attributes' => $attributes]; ?>
<?php $__slots1c2994ef08fa326e570a3e2362f1a0aa = []; ?>
<?php ob_start(); ?>
    <ui-checkbox <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> data-flux-control data-flux-checkbox>
        <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/checkbox/indicator.blade.php', $__blaze->compiledPath.'/67923520757e40e5050d29f4fc0ed6a4.php'); ?>
<?php $__blaze->pushData([]); ?>
<?php __67923520757e40e5050d29f4fc0ed6a4($__blaze, [], [], [], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
    </ui-checkbox>
<?php $__slots1c2994ef08fa326e570a3e2362f1a0aa['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrs1c2994ef08fa326e570a3e2362f1a0aa); ?>
<?php $__blaze->pushSlots($__slots1c2994ef08fa326e570a3e2362f1a0aa); ?>
<?php __1c2994ef08fa326e570a3e2362f1a0aa($__blaze, $__attrs1c2994ef08fa326e570a3e2362f1a0aa, $__slots1c2994ef08fa326e570a3e2362f1a0aa, ['attributes'], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slots1c2994ef08fa326e570a3e2362f1a0aa = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrs1c2994ef08fa326e570a3e2362f1a0aa = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/checkbox/variants/default.blade.php ENDPATH**/ ?>