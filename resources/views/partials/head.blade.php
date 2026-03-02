<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Home' }} | MERE APP</title>

<script>
 // Theme initialization to prevent flash
 (function () {
 const theme = localStorage.getItem('theme') || 'system';
 if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
 document.documentElement.classList.add('dark');
 } else {
 document.documentElement.classList.remove('dark');
 }
 })();
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Stores Initialization -->
<script>
 function initGlobalStores() {
 if (!window.Alpine) return;

 // Sidebar Store
 if (!Alpine.store('sidebar')) {
 Alpine.store('sidebar', {
 isExpanded: window.innerWidth >= 1280,
 isMobileOpen: false,
 isHovered: false,
 init() {
 window.addEventListener('resize', () => {
 if (window.innerWidth < 1280) {
 this.isMobileOpen = false;
 this.isExpanded = false;
 } else {
 this.isMobileOpen = false;
 this.isExpanded = true;
 }
 });
 },
 toggleExpanded() { this.isExpanded = !this.isExpanded; this.isMobileOpen = false; },
 setMobileOpen(val) { this.isMobileOpen = val; },
 setHovered(val) { if (window.innerWidth >= 1280 && !this.isExpanded) this.isHovered = val; }
 });
 }
 }

 document.addEventListener('alpine:init', initGlobalStores);
</script>

@livewireStyles
@stack('styles')