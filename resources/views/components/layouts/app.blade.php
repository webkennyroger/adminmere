<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" flux-appearance="system">

<head>
    @include('partials.head')
</head>

<body x-data="{ loaded: true }" class="min-h-screen bg-zinc-50 dark:bg-zinc-900 transition-colors duration-300">
    {{-- preloader --}}
    <x-common.preloader />

    <!-- ===== Page Wrapper Start ===== -->
    <div class="min-h-screen xl:flex">
        <!-- ===== Sidebar Start ===== -->
        <x-layouts.sidebar.sidebar />

        <!-- ===== Content Area Start ===== -->
        <div class="flex-1 transition-all duration-300 ease-in-out xl:ml-[90px]" :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- ===== Header Start ===== -->
            <x-layouts.header.app-header />

            <main class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6 transition-all duration-300">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Toast Container -->
    <x-toast.container />

    @if(session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showToast('success', "{{ session('message') }}");
            });
        </script>
    @endif

    @fluxScripts
    @livewireScripts

    <!-- Quill JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    @stack('scripts')
</body>

</html>