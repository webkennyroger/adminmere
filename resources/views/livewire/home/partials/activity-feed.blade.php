<div class="space-y-6">
    <!-- Feed Items -->
    @forelse($activities as $activity)
        <livewire:home.partials.activity-item :activity="$activity" :key="'activity-' . $activity->id" />
    @empty
        <div class="text-center py-12">
            <p class="text-zinc-500 dark:text-zinc-400">Nenhuma atividade recente.</p>
        </div>
    @endforelse
</div>