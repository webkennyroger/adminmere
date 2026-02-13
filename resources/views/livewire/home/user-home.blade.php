<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left Sidebar -->
        <aside class="lg:col-span-3 space-y-6">
            <livewire:home.partials.user-profile-card />

            <livewire:home.partials.left-sidebar />
        </aside>

        <!-- Main Feed -->
        <main class="lg:col-span-6 space-y-6">
            @if($feed === 'timeline')
                <livewire:home.partials.stories />
            @endif
            <livewire:home.partials.activity-feed :feed="$feed" />
        </main>

        <!-- Right Sidebar -->
        <aside class="lg:col-span-3 space-y-6">
            <livewire:home.partials.right-sidebar />
        </aside>
    </div>

    <!-- Lightbox Component -->
    @include('components.lightbox')
</div>