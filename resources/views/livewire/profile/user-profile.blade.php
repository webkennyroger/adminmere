<div>
    <x-common.page-breadcrumb pageTitle="Perfil de Usuário" />
    <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-white/[0.03] lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-zinc-800 dark:text-white/90 lg:mb-7">Perfil</h3>
        
        @include('livewire.profile.header-card') {{-- Header Card --}}
        @include('livewire.profile.personal-info-card')
        @include('livewire.profile.address-card')
        @include('livewire.profile.social-media-card')
    </div>
</div>
