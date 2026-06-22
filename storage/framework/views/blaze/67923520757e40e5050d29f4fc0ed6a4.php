<?php
if (!function_exists('__67923520757e40e5050d29f4fc0ed6a4')):
function __67923520757e40e5050d29f4fc0ed6a4($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<?php
$classes = Flux::classes()
    ->add('shrink-0 size-[1.125rem] rounded-[.3rem] flex justify-center items-center')
    ->add('text-sm text-zinc-700 dark:text-zinc-800')
    ->add('shadow-xs [ui-checkbox[disabled]_&]:opacity-75 [ui-checkbox[data-checked][disabled]_&]:opacity-50 [ui-checkbox[disabled]_&]:shadow-none [ui-checkbox[data-checked]_&]:shadow-none [ui-checkbox[data-indeterminate]_&]:shadow-none')
    ->add('[ui-checkbox[data-checked]:not([data-indeterminate])_&>svg:first-child]:block [ui-checkbox[data-indeterminate]_&>svg:last-child]:block')
    ->add([
        'border',
        'border-zinc-300 dark:border-white/10',
        '[ui-checkbox[disabled]_&]:border-zinc-200 dark:[ui-checkbox[disabled]_&]:border-white/5',
        '[ui-checkbox[data-checked]_&]:border-transparent [ui-checkbox[data-indeterminate]_&]:border-transparent',
        '[ui-checkbox[disabled][data-checked]_&]:border-transparent [ui-checkbox[disabled][data-indeterminate]_&]:border-transparent',
        '[print-color-adjust:exact]',
    ])
    ->add([
        'bg-white dark:bg-white/10',
        '[ui-checkbox[data-checked]_&]:bg-[var(--color-accent)]',
        'hover:[ui-checkbox[data-checked]_&]:bg-(--color-accent)',
        'focus:[ui-checkbox[data-checked]_&]:bg-(--color-accent)',
        '[ui-checkbox[data-indeterminate]_&]:bg-[var(--color-accent)]',
        'hover:[ui-checkbox[data-indeterminate]_&]:bg-(--color-accent)',
        'focus:[ui-checkbox[data-indeterminate]_&]:bg-(--color-accent)',
    ])
    ;
?>

<div <?php echo e($attributes->class($classes)); ?> data-flux-checkbox-indicator>
    <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/check.blade.php', $__blaze->compiledPath.'/3e18c37687f6adf85a7cd5cf067a7f49.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro','class' => 'hidden text-[var(--color-accent-foreground)]']); ?>
<?php __3e18c37687f6adf85a7cd5cf067a7f49($__blaze, ['variant' => 'micro','class' => 'hidden text-[var(--color-accent-foreground)]'], [], [], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/minus.blade.php', $__blaze->compiledPath.'/1262aeba574af5b9eed67c530a497de4.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro','class' => 'hidden text-[var(--color-accent-foreground)]']); ?>
<?php __1262aeba574af5b9eed67c530a497de4($__blaze, ['variant' => 'micro','class' => 'hidden text-[var(--color-accent-foreground)]'], [], [], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
</div>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/checkbox/indicator.blade.php ENDPATH**/ ?>