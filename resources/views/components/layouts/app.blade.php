<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | MERE APP</title>


    <!-- Theme initialization (runs before CSS loads) -->
    <script>
        const savedTheme = localStorage.getItem('theme');
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        const theme = savedTheme || systemTheme;
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            document.body.classList.add('dark', 'bg-zinc-900');
        }

        // Toast Manager (Inlined to ensure availability for Alpine)
        window.toastManager = function () {
            return {
                toasts: [],
                addToast(data) {
                    if (Array.isArray(data) && data.length > 0) data = data[0];
                    if (typeof data === 'string') data = { message: data, type: 'info' };

                    const id = Date.now() + Math.random();
                    const type = data.type || 'success';
                    const bgClasses = { success: 'bg-green-500', info: 'bg-blue-500', warning: 'bg-yellow-500', error: 'bg-red-500', custom: 'bg-orange-500' };
                    const textClasses = { success: 'text-green-500', info: 'text-blue-500', warning: 'text-yellow-500', error: 'text-red-500', custom: 'text-orange-500' };

                    let normalizedType = type;
                    if (!bgClasses[normalizedType]) normalizedType = 'success';

                    const toast = {
                        id,
                        type: normalizedType,
                        title: data.title || 'Notificação',
                        message: data.message || '',
                        bgClass: bgClasses[normalizedType],
                        textClass: textClasses[normalizedType],
                        show: false
                    };
                    this.toasts.push(toast);
                    setTimeout(() => {
                        const t = this.toasts.find(t => t.id === id);
                        if (t) t.show = true;
                    }, 100);
                    setTimeout(() => { this.removeToast(id); }, data.duration || 5000);
                },
                removeToast(id) {
                    const toastIndex = this.toasts.findIndex(t => t.id === id);
                    if (toastIndex !== -1) {
                        this.toasts[toastIndex].show = false;
                        setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 300);
                    }
                }
            }
        }
        window.showToast = function (type, message, title = null, duration = 5000) {
            window.dispatchEvent(new CustomEvent('toast', { detail: { type, message, title, duration } }));
        }
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Quill CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Alpine.js -->
    {{--
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}


    <!-- Livewire styles -->
    @livewireStyles

    <style>
        /* Flatpickr Dark Mode Overrides */
        .dark .flatpickr-calendar {
            background: #18181b !important;
            border-color: #27272a !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .dark .flatpickr-calendar.arrowTop:before,
        .dark .flatpickr-calendar.arrowTop:after {
            border-bottom-color: #18181b !important;
        }

        .dark .flatpickr-calendar.arrowBottom:before,
        .dark .flatpickr-calendar.arrowBottom:after {
            border-top-color: #18181b !important;
        }

        .dark .flatpickr-months .flatpickr-month {
            background: #18181b !important;
            color: #e4e4e7 !important;
            fill: #e4e4e7 !important;
        }

        .dark .flatpickr-months .flatpickr-prev-month,
        .dark .flatpickr-months .flatpickr-next-month {
            color: #e4e4e7 !important;
            fill: #e4e4e7 !important;
        }

        .dark .flatpickr-months .flatpickr-prev-month:hover svg,
        .dark .flatpickr-months .flatpickr-next-month:hover svg {
            fill: #fff !important;
        }

        .dark .flatpickr-current-month .flatpickr-monthDropdown-months {
            background: #18181b !important;
            color: #e4e4e7 !important;
        }

        .dark .flatpickr-current-month .flatpickr-monthDropdown-months .flatpickr-monthDropdown-month {
            background-color: #18181b !important;
        }

        .dark .flatpickr-current-month input.cur-year {
            color: #e4e4e7 !important;
        }

        .dark .flatpickr-weekdays {
            background: #18181b !important;
        }

        .dark span.flatpickr-weekday {
            background: #18181b !important;
            color: #a1a1aa !important;
        }

        .dark .flatpickr-day {
            color: #e4e4e7 !important;
        }

        .dark .flatpickr-day.inRange,
        .dark .flatpickr-day.prevMonthDay.inRange,
        .dark .flatpickr-day.nextMonthDay.inRange,
        .dark .flatpickr-day.today.inRange,
        .dark .flatpickr-day.prevMonthDay.today.inRange,
        .dark .flatpickr-day.nextMonthDay.today.inRange,
        .dark .flatpickr-day:hover,
        .dark .flatpickr-day.prevMonthDay:hover,
        .dark .flatpickr-day.nextMonthDay:hover,
        .dark .flatpickr-day:focus,
        .dark .flatpickr-day.prevMonthDay:focus,
        .dark .flatpickr-day.nextMonthDay:focus {
            background: #27272a !important;
            border-color: #27272a !important;
            color: #fff !important;
        }

        .dark .flatpickr-day.selected,
        .dark .flatpickr-day.startRange,
        .dark .flatpickr-day.endRange,
        .dark .flatpickr-day.selected.inRange,
        .dark .flatpickr-day.startRange.inRange,
        .dark .flatpickr-day.endRange.inRange,
        .dark .flatpickr-day.selected:focus,
        .dark .flatpickr-day.startRange:focus,
        .dark .flatpickr-day.endRange:focus,
        .dark .flatpickr-day.selected:hover,
        .dark .flatpickr-day.startRange:hover,
        .dark .flatpickr-day.endRange:hover,
        .dark .flatpickr-day.selected.prevMonthDay,
        .dark .flatpickr-day.startRange.prevMonthDay,
        .dark .flatpickr-day.endRange.prevMonthDay,
        .dark .flatpickr-day.selected.nextMonthDay,
        .dark .flatpickr-day.startRange.nextMonthDay,
        .dark .flatpickr-day.endRange.nextMonthDay {
            background: #16a34a !important;
            /* brand-600 */
            border-color: #16a34a !important;
            color: #fff !important;
        }

        .dark .flatpickr-time {
            background: #18181b !important;
            border-top: 1px solid #27272a !important;
        }

        .dark .flatpickr-time .flatpickr-time-separator,
        .dark .flatpickr-time .flatpickr-am-pm {
            color: #e4e4e7 !important;
        }

        .dark .flatpickr-time input {
            color: #e4e4e7 !important;
        }

        .dark .flatpickr-time input:hover,
        .dark .flatpickr-time .flatpickr-am-pm:hover,
        .dark .flatpickr-time input:focus,
        .dark .flatpickr-time .flatpickr-am-pm:focus {
            background: #27272a !important;
        }
    </style>

    <!-- Additional styles -->
    @stack('styles')

    <!-- Theme Store & Sidebar Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' :
                        'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    const body = document.body;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                        body.classList.add('dark', 'bg-zinc-900');
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark', 'bg-zinc-900');
                    }
                }
            });

            Alpine.store('sidebar', {
                // Initialize based on screen size
                isExpanded: window.innerWidth >= 1280, // true for desktop, false for mobile
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    // When toggling desktop sidebar, ensure mobile menu is closed
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                    // Don't modify isExpanded when toggling mobile menu
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    // Only allow hover effects on desktop when sidebar is collapsed
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });

            Alpine.store('chatSidebar', {
                isOpen: false,
                toggle() {
                    this.isOpen = !this.isOpen;
                }
            });
        });
    </script>

    <!-- Apply dark mode  -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                if (document.body) {
                    document.body.classList.add('dark', 'bg-zinc-900');
                }
            } else {
                document.documentElement.classList.remove('dark');
                if (document.body) {
                    document.body.classList.remove('dark', 'bg-zinc-900');
                }
            }
        })();
    </script>

</head>

<body x-data="{ 'loaded': true}" x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);">

    {{-- preloader --}}
    <x-common.preloader />
    {{-- preloader end --}}


    <!-- ===== Page Wrapper Start ===== -->
    <div class="min-h-screen xl:flex">
        <!-- ===== Sidebar Start ===== -->
        <x-layouts.sidebar.sidebar />
        <!-- ===== Sidebar End ===== -->
        <!-- ===== Content Area Start ===== -->
        <div class="flex-1 transition-all duration-300 ease-in-out" :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- ===== Header Start ===== -->
            <x-layouts.header.app-header />
            <!-- ===== Header End ===== -->
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                {{ $slot }}
            </div>
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    <!-- Chat Components -->
    <livewire:chat.chat-sidebar />
    <livewire:chat.chat-box />

    <!-- Toast Container -->
    <x-toast.container />

    @if(session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showToast('success', "{{ session('message') }}");
            });
        </script>
    @endif

    <!-- Quill JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <!-- Livewire scripts -->
    @livewireScripts
    @stack('scripts')
</body>

</html>