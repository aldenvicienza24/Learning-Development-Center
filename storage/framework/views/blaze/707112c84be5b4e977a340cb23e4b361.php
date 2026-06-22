<?php
if (!function_exists('__707112c84be5b4e977a340cb23e4b361')):
function __707112c84be5b4e977a340cb23e4b361($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<?php
$__defaults = [
    'orientation' => null,
    'vertical' => false,
    'variant' => null,
    'faint' => false,
    'text' => null,
];
$orientation ??= $attributes['orientation'] ?? $__defaults['orientation']; unset($attributes['orientation']);
$vertical ??= $attributes['vertical'] ?? $__defaults['vertical']; unset($attributes['vertical']);
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
$faint ??= $attributes['faint'] ?? $__defaults['faint']; unset($attributes['faint']);
$text ??= $attributes['text'] ?? $__defaults['text']; unset($attributes['text']);
unset($__defaults);
?>

<?php
$orientation ??= $vertical ? 'vertical' : 'horizontal';

$classes = Flux::classes('border-0 [print-color-adjust:exact]')
    ->add(match ($variant) {
        'subtle' => 'bg-zinc-800/5 dark:bg-white/10',
        default => 'bg-zinc-800/15 dark:bg-white/20',
    })
    ->add(match ($orientation) {
        'horizontal' => 'h-px w-full',
        'vertical' => 'self-stretch self-center w-px',
    })
    ;
?>

<?php if ($text): ?>
    <div data-orientation="<?php echo e($orientation); ?>" class="flex items-center w-full" role="none" data-flux-separator>
        <div <?php echo e($attributes->class([$classes, 'grow'])); ?>></div>

        <span class="shrink mx-6 font-medium text-sm text-zinc-500 dark:text-zinc-300 whitespace-nowrap"><?php echo e($text); ?></span>

        <div <?php echo e($attributes->class([$classes, 'grow'])); ?>></div>
    </div>
<?php else: ?>
    <div data-orientation="<?php echo e($orientation); ?>" role="none" <?php echo e($attributes->class($classes, 'shrink-0')); ?> data-flux-separator></div>
<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/separator.blade.php ENDPATH**/ ?>