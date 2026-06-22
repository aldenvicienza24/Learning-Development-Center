<?php
if (!function_exists('__48b734dd457251af2933f65d9362e7bc')):
function __48b734dd457251af2933f65d9362e7bc($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<?php
extract(Flux::forwardedAttributes($attributes, [
    'name',
    'descriptionTrailing',
    'description',
    'label',
    'badge',
]));
?>

<?php $descriptionTrailing = $descriptionTrailing ??= $attributes->pluck('description:trailing'); ?>

<?php
$__defaults = [
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'descriptionTrailing' => null,
    'description' => null,
    'label' => null,
    'badge' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$descriptionTrailing ??= $attributes['description-trailing'] ?? $attributes['descriptionTrailing'] ?? $__defaults['descriptionTrailing']; unset($attributes['descriptionTrailing'], $attributes['description-trailing']);
$description ??= $attributes['description'] ?? $__defaults['description']; unset($attributes['description']);
$label ??= $attributes['label'] ?? $__defaults['label']; unset($attributes['label']);
$badge ??= $attributes['badge'] ?? $__defaults['badge']; unset($attributes['badge']);
unset($__defaults);
?>

<?php if (isset($label) || isset($description)): ?>
    <?php

        $fieldAttributes = Flux::attributesAfter('field:', $attributes, []);
        $labelAttributes = Flux::attributesAfter('label:', $attributes, ['badge' => $badge]);
        $descriptionAttributes = Flux::attributesAfter('description:', $attributes, []);
        $errorAttributes = Flux::attributesAfter('error:', $attributes, ['name' => $name]);
    ?>
    <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/73f1f756701b7446d6b732b500086aa3.php'); ?>
<?php if (isset($__slots73f1f756701b7446d6b732b500086aa3)) $__slotsOriginal = $__slots73f1f756701b7446d6b732b500086aa3; ?>
<?php if (isset($__attrs73f1f756701b7446d6b732b500086aa3)) $__attrsOriginal = $__attrs73f1f756701b7446d6b732b500086aa3; ?>
<?php $__attrs73f1f756701b7446d6b732b500086aa3 = ['attributes' => $fieldAttributes]; ?>
<?php $__slots73f1f756701b7446d6b732b500086aa3 = []; ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/a74dfd16d6e86a5674db89fa547bcbe2.php'); ?>
<?php if (isset($__slotsa74dfd16d6e86a5674db89fa547bcbe2)) $__slotsOriginal = $__slotsa74dfd16d6e86a5674db89fa547bcbe2; ?>
<?php if (isset($__attrsa74dfd16d6e86a5674db89fa547bcbe2)) $__attrsOriginal = $__attrsa74dfd16d6e86a5674db89fa547bcbe2; ?>
<?php $__attrsa74dfd16d6e86a5674db89fa547bcbe2 = ['attributes' => $labelAttributes]; ?>
<?php $__slotsa74dfd16d6e86a5674db89fa547bcbe2 = []; ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slotsa74dfd16d6e86a5674db89fa547bcbe2['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrsa74dfd16d6e86a5674db89fa547bcbe2); ?>
<?php $__blaze->pushSlots($__slotsa74dfd16d6e86a5674db89fa547bcbe2); ?>
<?php __a74dfd16d6e86a5674db89fa547bcbe2($__blaze, $__attrsa74dfd16d6e86a5674db89fa547bcbe2, $__slotsa74dfd16d6e86a5674db89fa547bcbe2, ['attributes'], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slotsa74dfd16d6e86a5674db89fa547bcbe2 = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrsa74dfd16d6e86a5674db89fa547bcbe2 = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/5325bce76d5fd78b5426438dbf19e529.php'); ?>
<?php if (isset($__slots5325bce76d5fd78b5426438dbf19e529)) $__slotsOriginal = $__slots5325bce76d5fd78b5426438dbf19e529; ?>
<?php if (isset($__attrs5325bce76d5fd78b5426438dbf19e529)) $__attrsOriginal = $__attrs5325bce76d5fd78b5426438dbf19e529; ?>
<?php $__attrs5325bce76d5fd78b5426438dbf19e529 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots5325bce76d5fd78b5426438dbf19e529 = []; ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slots5325bce76d5fd78b5426438dbf19e529['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrs5325bce76d5fd78b5426438dbf19e529); ?>
<?php $__blaze->pushSlots($__slots5325bce76d5fd78b5426438dbf19e529); ?>
<?php __5325bce76d5fd78b5426438dbf19e529($__blaze, $__attrs5325bce76d5fd78b5426438dbf19e529, $__slots5325bce76d5fd78b5426438dbf19e529, ['attributes'], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slots5325bce76d5fd78b5426438dbf19e529 = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrs5325bce76d5fd78b5426438dbf19e529 = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        [STARTCOMPILEDUNBLAZE:SciHhO4nFv]<?php \Livewire\Blaze\Unblaze::storeScope("SciHhO4nFv", scope: ['attributes' => $errorAttributes->all()]) ?>[ENDCOMPILEDUNBLAZE:SciHhO4nFv]

        <?php if (isset($descriptionTrailing)): ?>
            <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/5325bce76d5fd78b5426438dbf19e529.php'); ?>
<?php if (isset($__slots5325bce76d5fd78b5426438dbf19e529)) $__slotsOriginal = $__slots5325bce76d5fd78b5426438dbf19e529; ?>
<?php if (isset($__attrs5325bce76d5fd78b5426438dbf19e529)) $__attrsOriginal = $__attrs5325bce76d5fd78b5426438dbf19e529; ?>
<?php $__attrs5325bce76d5fd78b5426438dbf19e529 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots5325bce76d5fd78b5426438dbf19e529 = []; ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slots5325bce76d5fd78b5426438dbf19e529['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrs5325bce76d5fd78b5426438dbf19e529); ?>
<?php $__blaze->pushSlots($__slots5325bce76d5fd78b5426438dbf19e529); ?>
<?php __5325bce76d5fd78b5426438dbf19e529($__blaze, $__attrs5325bce76d5fd78b5426438dbf19e529, $__slots5325bce76d5fd78b5426438dbf19e529, ['attributes'], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slots5325bce76d5fd78b5426438dbf19e529 = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrs5325bce76d5fd78b5426438dbf19e529 = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots73f1f756701b7446d6b732b500086aa3['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrs73f1f756701b7446d6b732b500086aa3); ?>
<?php $__blaze->pushSlots($__slots73f1f756701b7446d6b732b500086aa3); ?>
<?php __73f1f756701b7446d6b732b500086aa3($__blaze, $__attrs73f1f756701b7446d6b732b500086aa3, $__slots73f1f756701b7446d6b732b500086aa3, ['attributes'], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slots73f1f756701b7446d6b732b500086aa3 = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrs73f1f756701b7446d6b732b500086aa3 = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>