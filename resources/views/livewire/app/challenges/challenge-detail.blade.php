<div class="bg-white dark:bg-zinc-950 min-h-screen font-sans">
 <!-- Hero Banner -->
 <div class="relative w-full h-48 md:h-64 bg-[#FC4C02] overflow-hidden">
 <!-- Abstract Background Shapes -->
 <div class="absolute inset-0">
 <div
 class="absolute -top-24 -left-24 w-96 h-96 bg-orange-600 mix-blend-multiply filter blur-3xl opacity-50">
 </div>
 <div
 class="absolute -bottom-24 -right-24 w-96 h-96 bg-yellow-500 mix-blend-multiply filter blur-3xl opacity-50">
 </div>
 <!-- Dynamic lines -->
 <svg class="absolute inset-0 w-full h-full opacity-10" viewBox="0 0 100 100" preserveAspectRatio="none">
 <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
 </svg>
 </div>

 @if($challenge->image)
 <img src="{{ Storage::url($challenge->image) }}" class="absolute inset-0 w-full h-full object-cover opacity-50">
 @endif

 <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
 <h1
 class="text-4xl md:text-6xl font-black text-white uppercase italic tracking-tighter transform -skew-x-12 drop-shadow-lg">
 MERE<span class="text-white">RUN</span>
 </h1>
 </div>
 </div>

 <!-- Main Content Container -->
 <div class=" mx-auto px-4 sm:px-6 -mt-16 relative z-20 pb-20">

 <!-- Badge & Title Section -->
 <div class="text-center mb-8">
 <!-- Badge Icon -->
 <div class="relative inline-block">
 <div
 class="w-32 h-32 bg-cyan-400 rotate-45 flex items-center justify-center border-4 border-white dark:border-zinc-900 shadow-xl mx-auto mb-6 transform hover:scale-105 transition-transform duration-300">
 <div
 class="w-24 h-24 bg-cyan-500 flex items-center justify-center border-2 border-white/20">
 <div class="transform -rotate-45 text-white font-black text-center leading-tight">
 <span class="text-2xl">{{ intval($challenge->goal_km) }}</span>
 <span class="text-xs block">KM</span>
 </div>
 </div>
 </div>
 </div>

 <h1 class="text-3xl md:text-4xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">
 {{ $challenge->title }}
 </h1>
 <p class="text-zinc-600 dark:text-zinc-400 text-lg max-w-2xl mx-auto">
 {{ \Illuminate\Support\Str::limit(strip_tags($challenge->description), 150) }}
 </p>
 </div>

 <!-- Progress & Actions Grid -->
 <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
 <!-- Left: Progress -->
 <div class="lg:col-span-2 space-y-6" x-data="{ tab: 'overview' }">
 
 <div class="flex gap-6 border-b border-zinc-200 dark:border-zinc-800 mb-2">
 <button @click="tab = 'overview'" 
 :class="tab === 'overview' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200'"
 class="pb-3 border-b-2 font-bold text-sm transition-colors uppercase tracking-wide outline-none">
 Visão Geral
 </button>
 <button @click="tab = 'leaderboard'" 
 :class="tab === 'leaderboard' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200'"
 class="pb-3 border-b-2 font-bold text-sm transition-colors uppercase tracking-wide outline-none">
 Classificação
 </button>
 </div>

 <!-- Overview Tab -->
 <div x-show="tab === 'overview'"
 class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm transition-all duration-300">
 @if($isJoined)
 <div class="flex justify-between items-center mb-2">
 <span class="text-green-500 font-bold text-sm">{{ number_format($progress, 1) }} /
 {{ number_format($challenge->goal_km, 1) }} km</span>
 <span class="text-green-500 font-bold text-sm uppercase tracking-wider">
 {{ $percent >= 100 ? 'Concluído' : 'Em Progresso' }}
 </span>
 </div>

 <!-- Progress Bar -->
 <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-4 mb-6">
 <div class="bg-green-500 h-4 shadow-[0_0_10px_rgba(34,197,94,0.5)] transition-all duration-1000"
 style="width: {{ $percent }}%"></div>
 </div>
 @else
 <div class="mb-6">
 <div class="bg-zinc-100 dark:bg-zinc-800 p-4 text-center">
 <p class="text-zinc-500 dark:text-zinc-400">Você ainda não está participando deste desafio.
 </p>
 <button wire:click="join"
 class="mt-3 bg-[#FC4C02] hover:bg-[#e04302] text-white font-bold py-2 px-6 shadow-sm transition-colors uppercase text-sm tracking-wide">
 Participar Agora
 </button>
 </div>
 </div>
 @endif

 <div class="space-y-4">
 <div class="flex items-start gap-4">
 <div class="mt-1">
 <svg class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
 </svg>
 </div>
 <div>
 <p class="text-sm font-medium text-zinc-900 dark:text-zinc-200">
 {{ $challenge->start_date->isoFormat('D [de] MMM. [de] YYYY') }} a
 {{ $challenge->end_date->isoFormat('D [de] MMM. [de] YYYY') }}
 </p>
 </div>
 </div>

 <div class="flex items-start gap-4">
 <div class="mt-1">
 <svg class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M13 10V3L4 14h7v7l9-11h-7z" />
 </svg>
 </div>
 <div>
 <p class="text-sm font-medium text-zinc-900 dark:text-zinc-200">Meta:
 {{ number_format($challenge->goal_km, 0, ',', '.') }} km
 </p>
 <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Categoria:
 {{ $challenge->category->name ?? 'Geral' }}
 </p>
 </div>
 </div>

 <div class="flex items-start gap-4">
 <div class="mt-1">
 <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
 </svg>
 </div>
 <div>
 <p class="text-sm font-medium text-zinc-900 dark:text-zinc-200">Ganhe uma medalha de
 finalização digital para sua Coleção de troféus.</p>
 </div>
 </div>
 </div>
 </div>

 <!-- Leaderboard Tab -->
 <div x-show="tab === 'leaderboard'" style="display: none;"
 class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
 <div class="p-4 border-b border-zinc-100 dark:border-zinc-800">
 <h3 class="font-bold text-zinc-900 dark:text-white">Top Participantes</h3>
 </div>
 @if($leaderboard && $leaderboard->count() > 0)
 <div class="overflow-x-auto">
 <table class="w-full text-sm text-left">
 <thead class="text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-800/50">
 <tr>
 <th class="px-4 py-3">#</th>
 <th class="px-4 py-3">Atleta</th>
 <th class="px-4 py-3 text-right">Progresso</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
 @foreach($leaderboard as $index => $user)
 <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
 <td class="px-4 py-3 font-medium text-zinc-500 w-10">{{ $index + 1 }}</td>
 <td class="px-4 py-3">
 <div class="flex items-center gap-3">
 <div class="w-8 h-8 bg-zinc-200 dark:bg-zinc-700 overflow-hidden">
 @if($user->profile_photo_path)
 <img src="{{ Storage::url($user->profile_photo_path) }}" class="w-full h-full object-cover">
 @else
 <div class="w-full h-full flex items-center justify-center text-xs font-bold text-zinc-500">
 {{ substr($user->name, 0, 1) }}
 </div>
 @endif
 </div>
 <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $user->name }}</span>
 </div>
 </td>
 <td class="px-4 py-3 text-right font-bold text-zinc-900 dark:text-white">
 {{ number_format($user->pivot->progress, 1, ',', '.') }} km
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>
 @else
 <div class="p-8 text-center text-zinc-500 dark:text-zinc-400">
 Ainda não há classificação disponível.
 </div>
 @endif
 </div>

 <!-- Details / Dropdowns (Restored Accordion) -->
 <div class="space-y-4">
 <div x-data="{ open: true }"
 class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 overflow-hidden">
 <button @click="open = !open" class="flex items-center justify-between w-full p-4 text-left">
 <h3 class="font-bold text-zinc-900 dark:text-white">Detalhes e qualificação</h3>
 <svg class="w-5 h-5 text-zinc-500 transition-transform" :class="{'rotate-180': open}"
 fill="none" viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M19 9l-7 7-7-7" />
 </svg>
 </button>
 <div x-show="open" class="px-4 pb-6 pt-0 text-sm text-zinc-600 dark:text-zinc-400 space-y-4">
 <div>
 <h4 class="font-bold text-zinc-900 dark:text-zinc-200 mb-1">Descrição Completa</h4>
 <div class="prose dark:prose-invert max-w-none text-sm">
 {!! $challenge->description !!}
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>

 <!-- Right Sidebar Stats -->
 <div class="space-y-6">
 <!-- Action Buttons -->
 <div class="space-y-3">
 @if(!$isJoined)
 <button wire:click="join"
 class="w-full bg-[#FC4C02] hover:bg-[#e04302] text-white font-bold py-3 px-4 shadow-sm transition-colors uppercase text-sm tracking-wide">
 Participar do Desafio
 </button>
 @else
 <button wire:click="confirmLeave"
 class="w-full bg-white hover:bg-red-50 text-red-600 font-bold py-3 px-4 border border-red-200 hover:border-red-300 transition-colors uppercase text-sm tracking-wide">
 Sair do Desafio
 </button>
 @endif
 </div>

 <!-- Global Stats (Static/Placeholder) -->
 <div
 class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm text-center">
 <p class="text-xs text-zinc-500 uppercase tracking-widest font-bold mb-1">Participantes</p>
 <p class="text-3xl font-black text-zinc-900 dark:text-white mb-6">{{ $challenge->users()->count() }}
 </p>

 @if($isJoined)
 <div class="border-t border-zinc-100 dark:border-zinc-800 pt-6">
 <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-6 text-center">Suas estatísticas
 gerais</h4>

 <div class="space-y-6">
 <div class="grid grid-cols-2 gap-4">
 <div class="text-center border-r border-zinc-100 dark:border-zinc-800">
 <p class="text-[10px] text-zinc-500 uppercase">Distância</p>
 <p class="text-xl font-bold text-zinc-900 dark:text-white">
 {{ number_format($progress > 0 ? $progress : 16.1, 1, ',', '.') }} km
 </p>
 </div>
 <div class="text-center">
 <p class="text-[10px] text-zinc-500 uppercase">Tempo de mov.</p>
 <p class="text-xl font-bold text-zinc-900 dark:text-white">1h 17min</p>
 </div>
 </div>

 <div class="grid grid-cols-2 gap-4 border-t border-zinc-100 dark:border-zinc-800 pt-6">
 <div class="text-center border-r border-zinc-100 dark:border-zinc-800">
 <p class="text-[10px] text-zinc-500 uppercase">Ganho de elev.</p>
 <p class="text-xl font-bold text-zinc-900 dark:text-white">148 m</p>
 </div>
 <div class="text-center">
 <p class="text-[10px] text-zinc-500 uppercase">Tempo decorrido</p>
 <p class="text-xl font-bold text-zinc-900 dark:text-white">1h 19min</p>
 </div>
 </div>
 </div>
 </div>
 @endif
 </div>

 </div>
 </div>

 <!-- Leave Confirmation Modal -->
 @if($showLeaveModal)
 <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
 <div class="fixed inset-0 bg-zinc-900/50 backdrop-blur-sm transition-opacity"
 wire:click="$set('showLeaveModal', false)"></div>

 <div
 class="relative w-full max-w-md bg-white dark:bg-zinc-900 p-6 shadow-xl ring-1 ring-zinc-900/5 transition-all transform">
 <div class="text-center">
 <div
 class="mx-auto flex h-12 w-12 items-center justify-center bg-red-100 dark:bg-red-900/20 mb-4">
 <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round"
 d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
 </svg>
 </div>
 <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Sair do Desafio?</h3>
 <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
 Tem certeza que deseja sair deste desafio? Todo o seu progresso será perdido e não poderá ser
 recuperado.
 </p>
 </div>
 <div class="mt-6 flex gap-3">
 <button wire:click="$set('showLeaveModal', false)"
 class="flex-1 px-4 py-2 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-700 font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
 Cancelar
 </button>
 <button wire:click="leave"
 class="flex-1 px-4 py-2 bg-red-600 text-white font-bold hover:bg-red-700 transition-colors shadow-sm">
 Sim, Sair
 </button>
 </div>
 </div>
 </div>
 @endif
 </div>
</div>
</div>