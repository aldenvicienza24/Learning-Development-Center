<?php
if (!function_exists('__a21338b399cc9372b4a2dc5e7b96d8b1')):
function __a21338b399cc9372b4a2dc5e7b96d8b1($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;
$errors = $__blaze->errors;
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<?php
$__defaults = [
    'icon' => 'exclamation-triangle',
    'bag' => 'default',
    'message' => null,
    'deep' => true,
    'nested' => true,
    'name' => null,
];
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
$bag ??= $attributes['bag'] ?? $__defaults['bag']; unset($attributes['bag']);
$message ??= $attributes['message'] ?? $__defaults['message']; unset($attributes['message']);
$deep ??= $attributes['deep'] ?? $__defaults['deep']; unset($attributes['deep']);
$nested ??= $attributes['nested'] ?? $__defaults['nested']; unset($attributes['nested']);
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
unset($__defaults);
?>

<?php
$errorBag = $errors->getBag($bag);
$message ??= $name ? $errorBag->first($name) : null;

// Backwards compatibility...
if ($nested === false) {
    $deep = false;
}

if ($name && (is_null($message) || $message === '') && filter_var($deep, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== false) {
    $message = $errorBag->first($name . '.*');
}

$classes = Flux::classes('mt-3 text-sm font-medium text-red-500 dark:text-red-400')
    ->add($message ? '' : 'hidden');
?>

<div role="alert" aria-live="polite" aria-atomic="true" <?php echo e($attributes->class($classes)); ?> data-flux-error>
    <?php if ($message) : ?>
        <?php if ($icon) : ?>
            <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/4ea6fb3a4f7e59fefc1fe1a37fee0589.php'); ?>
<?php $__blaze->pushData(['name' => $icon,'variant' => 'mini','class' => 'inline']); ?>
<?php __4ea6fb3a4f7e59fefc1fe1a37fee0589($__blaze, ['name' => $icon,'variant' => 'mini','class' => 'inline'], [], ['name'], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($message); ?>

    <?php endif; ?>
</div>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php ENDPATH**/ ?>