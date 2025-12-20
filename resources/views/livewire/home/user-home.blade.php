
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left Sidebar (Profile & Menu) -->
        <aside class="lg:col-span-3 space-y-6">
            <livewire:home.partials.user-profile-card />

            <livewire:home.partials.left-sidebar />
        </aside>

        <!-- Main Feed -->
        <main class="lg:col-span-6 space-y-6">
            <livewire:home.partials.activity-feed />
        </main>

        <!-- Right Sidebar (Upsell/Suggestions) -->
        <aside class="lg:col-span-3 space-y-6">
            <livewire:home.partials.right-sidebar />
        </aside>
    </div>
</div>

    