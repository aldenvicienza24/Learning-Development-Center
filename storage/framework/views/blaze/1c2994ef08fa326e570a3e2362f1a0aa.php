<?php
if (!function_exists('__1c2994ef08fa326e570a3e2362f1a0aa')):
function __1c2994ef08fa326e570a3e2362f1a0aa($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<?php
extract(flux::forwardedattributes($attributes, [
    'name',
    'description',
    'label',
]));
?>

<?php
$__defaults = [
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'description' => null,
    'label' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$description ??= $attributes['description'] ?? $__defaults['description']; unset($attributes['description']);
$label ??= $attributes['label'] ?? $__defaults['label']; unset($attributes['label']);
unset($__defaults);
?>

<?php if (isset($label) || isset($description)): ?>
    <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/73f1f756701b7446d6b732b500086aa3.php'); ?>
<?php if (isset($__slots73f1f756701b7446d6b732b500086aa3)) $__slotsOriginal = $__slots73f1f756701b7446d6b732b500086aa3; ?>
<?php if (isset($__attrs73f1f756701b7446d6b732b500086aa3)) $__attrsOriginal = $__attrs73f1f756701b7446d6b732b500086aa3; ?>
<?php $__attrs73f1f756701b7446d6b732b500086aa3 = ['variant' => 'inline']; ?>
<?php $__slots73f1f756701b7446d6b732b500086aa3 = []; ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>


        <?php if (isset($label)): ?>
            <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/a74dfd16d6e86a5674db89fa547bcbe2.php'); ?>
<?php if (isset($__slotsa74dfd16d6e86a5674db89fa547bcbe2)) $__slotsOriginal = $__slotsa74dfd16d6e86a5674db89fa547bcbe2; ?>
<?php if (isset($__attrsa74dfd16d6e86a5674db89fa547bcbe2)) $__attrsOriginal = $__attrsa74dfd16d6e86a5674db89fa547bcbe2; ?>
<?php $__attrsa74dfd16d6e86a5674db89fa547bcbe2 = []; ?>
<?php $__slotsa74dfd16d6e86a5674db89fa547bcbe2 = []; ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slotsa74dfd16d6e86a5674db89fa547bcbe2['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrsa74dfd16d6e86a5674db89fa547bcbe2); ?>
<?php $__blaze->pushSlots($__slotsa74dfd16d6e86a5674db89fa547bcbe2); ?>
<?php __a74dfd16d6e86a5674db89fa547bcbe2($__blaze, $__attrsa74dfd16d6e86a5674db89fa547bcbe2, $__slotsa74dfd16d6e86a5674db89fa547bcbe2, [], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slotsa74dfd16d6e86a5674db89fa547bcbe2 = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrsa74dfd16d6e86a5674db89fa547bcbe2 = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/5325bce76d5fd78b5426438dbf19e529.php'); ?>
<?php if (isset($__slots5325bce76d5fd78b5426438dbf19e529)) $__slotsOriginal = $__slots5325bce76d5fd78b5426438dbf19e529; ?>
<?php if (isset($__attrs5325bce76d5fd78b5426438dbf19e529)) $__attrsOriginal = $__attrs5325bce76d5fd78b5426438dbf19e529; ?>
<?php $__attrs5325bce76d5fd78b5426438dbf19e529 = []; ?>
<?php $__slots5325bce76d5fd78b5426438dbf19e529 = []; ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slots5325bce76d5fd78b5426438dbf19e529['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrs5325bce76d5fd78b5426438dbf19e529); ?>
<?php $__blaze->pushSlots($__slots5325bce76d5fd78b5426438dbf19e529); ?>
<?php __5325bce76d5fd78b5426438dbf19e529($__blaze, $__attrs5325bce76d5fd78b5426438dbf19e529, $__slots5325bce76d5fd78b5426438dbf19e529, [], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slots5325bce76d5fd78b5426438dbf19e529 = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrs5325bce76d5fd78b5426438dbf19e529 = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/a21338b399cc9372b4a2dc5e7b96d8b1.php'); ?>
<?php $__blaze->pushData(['name' => $name]); ?>
<?php __a21338b399cc9372b4a2dc5e7b96d8b1($__blaze, ['name' => $name], [], ['name'], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
    <?php $__slots73f1f756701b7446d6b732b500086aa3['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrs73f1f756701b7446d6b732b500086aa3); ?>
<?php $__blaze->pushSlots($__slots73f1f756701b7446d6b732b500086aa3); ?>
<?php __73f1f756701b7446d6b732b500086aa3($__blaze, $__attrs73f1f756701b7446d6b732b500086aa3, $__slots73f1f756701b7446d6b732b500086aa3, [], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slots73f1f756701b7446d6b732b500086aa3 = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrs73f1f756701b7446d6b732b500086aa3 = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>

<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/with-inline-field.blade.php ENDPATH**/ ?>