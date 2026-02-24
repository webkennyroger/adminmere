<div class="py-6 px-4 lg:px-6 max-w-[1400px] mx-auto space-y-8">
    @if($feed === 'timeline')
        <livewire:home.partials.stories />
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Main Feed — Center Column -->
        <main class="lg:col-span-8 space-y-5">
            <livewire:home.partials.activity-feed :feed="$feed" />
        </main>

        <!-- Right Sidebar -->
        <aside class="lg:col-span-4 space-y-5 hidden lg:block">

            <livewire:home.partials.right-sidebar />
        </aside>
    </div>
</div>