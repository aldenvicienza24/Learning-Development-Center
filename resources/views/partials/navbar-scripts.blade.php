<!-- resources/views/partials/navbar-scripts.blade.php -->
{{-- This file is kept for backward compatibility but the navbar script
     is now embedded directly in navbar.blade.php with a guard.
     This file does nothing if the navbar script already ran. --}}
<script>
// Guard: skip if navbar script from navbar.blade.php already ran
if (!window.__navbarInitialized) {
    console.warn('[navbar] navbar-scripts.blade.php loaded but navbar.blade.php script did not run. This should not happen.');
}
</script>
