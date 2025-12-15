<x-layouts.app>
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12">
                <livewire:dashboard.stats.stats />
            </div>
            {{-- Tabela de usuários --}}
            <div class="col-span-12 xl:col-span-8">
                <livewire:dashboard.user-growth-chart />
            </div>

            <div class="col-span-12 xl:col-span-4">
                <livewire:dashboard.goal-chart />
            </div>

            <div class="col-span-12">
                <livewire:dashboard.social-media-stats />
            </div>
            <div class="col-span-12">
                <livewire:dashboard.countries.top-countries />
            </div>
        </div>

    </div>
    <!-- Tabela de Desafios -->
    <div class="col-span-12 pt-5">
        <x-common.component-card title="Desafios">
            <livewire:challenges.challenge-index :perPage="5" :isEmbedded="true" />
        </x-common.component-card>
    </div>

</x-layouts.app>