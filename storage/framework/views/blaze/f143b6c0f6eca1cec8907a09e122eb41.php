<?php
if (!function_exists('__f143b6c0f6eca1cec8907a09e122eb41')):
function __f143b6c0f6eca1cec8907a09e122eb41($__blaze, $__data = [], $__slots = [], $__bound = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::sanitized($__data, $__bound);
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP); unset($__data, $__bound);
ob_start();
?>


<?php $iconTrailing ??= $attributes->pluck('icon:trailing'); ?>
<?php $iconVariant ??= $attributes->pluck('icon:variant'); ?>

<?php
$__defaults = [
    'iconTrailing' => null,
    'iconVariant' => 'mini',
    'variant' => 'default',
    'suffix' => null,
    'value' => null,
    'icon' => null,
    'kbd' => null,
];
$iconTrailing ??= $attributes['icon-trailing'] ?? $attributes['iconTrailing'] ?? $__defaults['iconTrailing']; unset($attributes['iconTrailing'], $attributes['icon-trailing']);
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
$suffix ??= $attributes['suffix'] ?? $__defaults['suffix']; unset($attributes['suffix']);
$value ??= $attributes['value'] ?? $__defaults['value']; unset($attributes['value']);
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
$kbd ??= $attributes['kbd'] ?? $__defaults['kbd']; unset($attributes['kbd']);
unset($__defaults);
?>

<?php
if ($kbd) $suffix = $kbd;

$iconClasses = Flux::classes()
    ->add('me-2')
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-5' : null)
    ;

$trailingIconClasses = Flux::classes()
    ->add('ms-auto text-zinc-400 [[data-flux-menu-item-icon]:hover_&]:text-current')
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-5' : null)
    ;

$classes = Flux::classes()
    ->add('flex items-center px-2 py-1.5 w-full focus:outline-hidden')
    ->add('rounded-md')
    ->add('text-start text-sm font-medium')
    ->add('[&[disabled]]:opacity-50')
    ->add(match ($variant) {
        'danger' => [
            'text-zinc-800 data-active:text-red-600 data-active:bg-red-50 dark:text-white dark:data-active:bg-red-400/20 dark:data-active:text-red-400',
            '**:data-flux-menu-item-icon:text-zinc-400 dark:**:data-flux-menu-item-icon:text-white/60 [&[data-active]_[data-flux-menu-item-icon]]:text-current',
        ],
        'default' => [
            'text-zinc-800 data-active:bg-zinc-50 dark:text-white dark:data-active:bg-zinc-600',
            '**:data-flux-menu-item-icon:text-zinc-400 dark:**:data-flux-menu-item-icon:text-white/60 [&[data-active]_[data-flux-menu-item-icon]]:text-current',
        ]
    })
    ;

$suffixClasses = Flux::classes()
    ->add('ms-auto text-xs text-zinc-400')
    ;
?>

<?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/button-or-link-pure.blade.php', $__blaze->compiledPath.'/ffafe8a55fba5c02d6863d1acfcbe15c.php'); ?>
<?php if (isset($__slotsffafe8a55fba5c02d6863d1acfcbe15c)) $__slotsOriginal = $__slotsffafe8a55fba5c02d6863d1acfcbe15c; ?>
<?php if (isset($__attrsffafe8a55fba5c02d6863d1acfcbe15c)) $__attrsOriginal = $__attrsffafe8a55fba5c02d6863d1acfcbe15c; ?>
<?php $__attrsffafe8a55fba5c02d6863d1acfcbe15c = ['attributes' => $attributes->class($classes),'data-flux-menu-item' => true,'data-flux-menu-item-has-icon' => !! $icon]; ?>
<?php $__slotsffafe8a55fba5c02d6863d1acfcbe15c = []; ?>
<?php ob_start(); ?>
    <?php if (is_string($icon) && $icon !== ''): ?>
        <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/4ea6fb3a4f7e59fefc1fe1a37fee0589.php'); ?>
<?php $__blaze->pushData(['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses,'data-flux-menu-item-icon' => true]); ?>
<?php __4ea6fb3a4f7e59fefc1fe1a37fee0589($__blaze, ['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses,'data-flux-menu-item-icon' => true], [], ['icon', 'variant', 'class', 'data-flux-menu-item-icon'], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
    <?php elseif ($icon): ?>
        <?php echo e($icon); ?>

    <?php else: ?>
        <div class="w-7 hidden [[data-flux-menu]:has(>[data-flux-menu-item-has-icon])_&]:block"></div>
    <?php endif; ?>

    <?php echo e($slot); ?>


    <?php if ($suffix): ?>
        <?php if (is_string($suffix)): ?>
            <div class="<?php echo e($suffixClasses); ?>">
                <?php echo e($suffix); ?>

            </div>
        <?php else: ?>
            <?php echo e($suffix); ?>

        <?php endif; ?>
    <?php endif; ?>

    <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
        <?php $__blaze->ensureRequired('C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/4ea6fb3a4f7e59fefc1fe1a37fee0589.php'); ?>
<?php $__blaze->pushData(['icon' => $iconTrailing,'variant' => $iconVariant,'class' => $trailingIconClasses,'data-flux-menu-item-icon' => true]); ?>
<?php __4ea6fb3a4f7e59fefc1fe1a37fee0589($__blaze, ['icon' => $iconTrailing,'variant' => $iconVariant,'class' => $trailingIconClasses,'data-flux-menu-item-icon' => true], [], ['icon', 'variant', 'class', 'data-flux-menu-item-icon'], isset($this) ? $this : null); ?>
<?php $__blaze->popData(); ?>
    <?php elseif ($iconTrailing): ?>
        <?php echo e($iconTrailing); ?>

    <?php endif; ?>

    <?php echo e($submenu ?? ''); ?>

<?php $__slotsffafe8a55fba5c02d6863d1acfcbe15c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushData($__attrsffafe8a55fba5c02d6863d1acfcbe15c); ?>
<?php $__blaze->pushSlots($__slotsffafe8a55fba5c02d6863d1acfcbe15c); ?>
<?php __ffafe8a55fba5c02d6863d1acfcbe15c($__blaze, $__attrsffafe8a55fba5c02d6863d1acfcbe15c, $__slotsffafe8a55fba5c02d6863d1acfcbe15c, ['attributes', 'data-flux-menu-item', 'data-flux-menu-item-has-icon'], isset($this) ? $this : null); ?>
<?php if (isset($__slotsOriginal)) { $__slotsffafe8a55fba5c02d6863d1acfcbe15c = $__slotsOriginal; unset($__slotsOriginal); } ?>
<?php if (isset($__attrsOriginal)) { $__attrsffafe8a55fba5c02d6863d1acfcbe15c = $__attrsOriginal; unset($__attrsOriginal); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\PROJECT\web-uisi\vendor\livewire\flux\src/../stubs/resources/views/flux/menu/item.blade.php ENDPATH**/ ?>