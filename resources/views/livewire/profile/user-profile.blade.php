
<div>
 <div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
 <!-- Hero/Cover -->
 <div class="relative w-full h-[200px] md:h-[350px]">
 @if($user->cover_url)
 <img src="{{ $user->cover_url }}" class="w-full h-full object-cover" alt="">
 @endif

 
 <a href="{{ route('profile.edit') }}" wire:navigate class="absolute top-4 right-4 md:top-6 md:right-6 bg-white p-2 md:p-2.5 shadow-md text-gray-500 hover:text-blue-500 transition">
 <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
 </a>
 </div>
 
 <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 relative mt-[-50px] md:mt-[-80px]">
 <div class="bg-white shadow-sm px-4 md:px-6 pb-6 md:pb-8 pt-16 md:pt-6 relative flex flex-col items-center md:block">
 <div class="absolute -top-[50px] md:-top-[60px] left-1/2 transform -translate-x-1/2 flex flex-col items-center">
 <div class="relative">
 <img src="{{ $user->image_url }}" alt="Profile" class="w-[100px] h-[100px] md:w-[120px] md:h-[120px] border-4 border-white object-cover shadow-lg">
 <button class="absolute -top-1 -right-1 md:-top-2 md:-right-2 bg-green-500 text-white p-1 md:p-1.5 border-2 border-white shadow-sm">
 <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
 </button>
 </div>
 @if($user->subscribed() || in_array($user->profile?->plan, ['pro', 'premium']))
 <span class="bg-emerald-400 text-white text-[10px] md:text-[11px] font-bold px-3 py-0.5 uppercase tracking-wider -mt-3 relative z-10 border-2 border-white">
 Assinante
 </span>
 @else
 <span class="bg-emerald-400 text-white text-[10px] md:text-[11px] font-bold px-3 py-0.5 uppercase tracking-wider -mt-3 relative z-10 border-2 border-white">
 Gratuito
 </span>
 @endif
 </div>

 <div class="w-full flex flex-col md:flex-row md:justify-between items-center mt-2 md:mt-0 gap-6 md:gap-0">
 <div class="order-1 md:order-2 w-full md:w-1/3 flex flex-col items-center text-center mt-2 md:mt-8">
 <h1 class="text-xl md:text-2xl mt-10 font-bold text-gray-900 flex items-center justify-center gap-1">
 {{ $user->name }}
 @if($user->isManager() || $user->isAdmin())
 <svg class="w-4 h-4 md:w-5 md:h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
 @endif
 
 </h1>
 <div class="flex flex-wrap justify-center items-center gap-2 md:gap-4 text-[13px] md:text-sm text-gray-500 mt-2">
 <span class="flex items-center gap-1">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> 
 {{ $user->profile->city ?? 'Localização não definida' }}
 </span>

 @if(auth()->id() !== $user->id)
 <button wire:click="toggleFollow" wire:loading.attr="disabled"
 class="group px-6 py-2 font-semibold transition-all shadow-sm flex items-center justify-center gap-2 min-w-[120px] {{ auth()->user()->isFollowing($user) ? 'bg-zinc-200 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-zinc-300 dark:border-zinc-700 hover:bg-yellow-500 hover:text-white hover:border-yellow-500' : 'bg-green-600 text-white hover:bg-green-700 shadow-green-900/20' }}">
 @if(auth()->user()->isFollowing($user))
 <span class="block group-hover:hidden">Seguindo</span>
 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 block group-hover:hidden" fill="none"
 viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
 </svg>
 <span class="hidden group-hover:block">Deixar de seguir</span>
 
 <span>Seguir</span>
 @endif
 </button>
 @else
 <a href="{{ route('profile.edit') }}" wire:navigate
 class="px-6 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors shadow-sm inline-block">
 Editar Perfil
 </a>
 @endif
 </div>
 </div>

 <div class="order-2 md:order-3 w-full md:w-1/3 flex justify-center md:justify-end gap-6 md:gap-8 text-center pt-2 md:pt-10">
 <div class="border-r border-zinc-100 dark:border-zinc-800 pr-6 md:border-none md:pr-0">
 <p class="text-lg md:text-xl font-bold text-gray-900">0</p>
 <p class="text-[12px] md:text-sm text-gray-400 font-medium tracking-wide">
 Seguidores
 </p>
 </div>
 <div class="border-r border-zinc-100 dark:border-zinc-800 pr-6 md:border-none md:pr-0">
 <p class="text-lg md:text-xl font-bold text-gray-900">0</p>
 <p class="text-[12px] md:text-sm text-gray-400 font-medium tracking-wide">
 Seguindo
 </p>
 </div>
 <div>
 <p class="text-lg md:text-xl font-bold text-gray-900">0</p>
 <p class="text-[12px] md:text-sm text-gray-400 font-medium tracking-wide">
 Atividades
 </p>
 </div>
 </div>

 <div class="order-3 md:order-1 w-full md:w-1/3 flex flex-col items-center md:items-start gap-4 md:mt-10">
 <div class="flex justify-center md:justify-start gap-2">
 <a href="#" class="w-8 h-8 bg-green-600 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
 <a href="#" class="w-8 h-8 bg-sky-400 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
 <a href="#" class="w-8 h-8 bg-pink-500 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg></a>
 <a href="#" class="w-8 h-8 bg-green-700 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg></a>
 <a href="#" class="w-8 h-8 bg-red-600 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
 </div>
 </div>

 </div>
 </div>

 <div class="bg-white dark:bg-zinc-900 border-r border-zinc-200/80 dark:border-zinc-800 mt-4 md:mt-6 shadow-sm px-2 md:px-4 py-2 relative">
 <div class="flex overflow-x-auto hide-scrollbar snap-x items-center justify-start md:justify-between px-2 md:px-8">
 <button wire:click="setTab('timeline')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'timeline' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'timeline' ? 'bg-green-500 text-white' : 'bg-green-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">Linha do tempo</span>
 </button>
 <button wire:click="setTab('about')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'about' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'about' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">Sobre</span>
 </button>
 <button wire:click="setTab('friends')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'friends' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'friends' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">Amigos</span>
 </button>
 <button wire:click="setTab('groups')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'groups' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'groups' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">Mensagem</span>
 </button>

 <button wire:click="setTab('groups')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'groups' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'groups' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">Comunidades</span>
 </button>
 </div>

 
 </div>

 

 <div class="mt-4 md:mt-6">
 @if($activeTab === 'timeline')
 <div class="bg-transparent h-40 flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
 Conteúdo da Timeline ({{ $activeSubTab }})
 </div>
 @endif
 </div>

 </div>
 
 </div>
 <!-- Main Content -->
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12">
 <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

 <!-- Left Header Info (Mobile Stacked, Desktop Inline with Tabs) -->
 <div class="lg:col-span-12 flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
 <div>
 <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $user->name }}</h1>
 <div class="flex items-center gap-2 text-zinc-500 dark:text-zinc-400 mt-1">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
 </svg>
 <span>{{ $user->profile->city ?? 'Localização não definida' }}</span>
 </div>
 </div>

 <div class="flex gap-4">
 @if(auth()->id() !== $user->id)
 <button wire:click="toggleFollow" wire:loading.attr="disabled"
 class="group px-6 py-2 font-semibold transition-all shadow-sm flex items-center justify-center gap-2 min-w-[120px] {{ auth()->user()->isFollowing($user) ? 'bg-zinc-200 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-zinc-300 dark:border-zinc-700 hover:bg-yellow-500 hover:text-white hover:border-yellow-500' : 'bg-green-600 text-white hover:bg-green-700 shadow-green-900/20' }}">
 @if(auth()->user()->isFollowing($user))
 <span class="block group-hover:hidden">Seguindo</span>
 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 block group-hover:hidden" fill="none"
 viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
 </svg>
 <span class="hidden group-hover:block">Deixar de seguir</span>
 @else
 <span>Seguir</span>
 @endif
 </button>
 @else
 <a href="{{ route('profile.edit') }}" wire:navigate
 class="px-6 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors shadow-sm inline-block">
 Editar Perfil
 </a>
 @endif
 </div>
 </div>

 <!-- Dashboard Stats & Tabs Area -->
 <div class="lg:col-span-8 space-y-8">
 <!-- Stats Overview Card -->
 <div
 class="bg-white dark:bg-zinc-900 p-6 shadow-sm border border-zinc-200 dark:border-zinc-800/50">
 <div class="flex flex-col sm:flex-row justify-between items-center gap-8">

 <!-- Main Counter -->
 <div class="text-center sm:text-left">
 <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">
 Últimas 4 semanas</p>
 <div class="flex items-baseline justify-center sm:justify-start gap-2 mt-1">
 <span
 class="text-5xl font-black text-zinc-900 dark:text-white tracking-tight">{{ $stats['total_activities_last_4_weeks'] }}</span>
 <span class="text-sm font-medium text-zinc-500">atividades</span>
 </div>
 </div>

 <!-- Mini Calendar Visualization (Mockup for Visual) -->
 <div class="flex-1 w-full max-w-sm">
 <div class="flex justify-between text-xs text-zinc-400 mb-2 font-mono">
 <span>SEG</span><span>QUA</span><span>SEX</span><span>DOM</span>
 </div>
 <div class="grid grid-cols-7 gap-1.5">
 @for($i = 0; $i < 28; $i++)
 <div
 class="aspect-square {{ rand(0, 3) > 1 ? 'bg-green-500' : 'bg-zinc-100 dark:bg-zinc-800' }}">
 </div>
 @endfor
 </div>
 <div class="flex justify-between items-center mt-2 text-[10px] text-zinc-400">
 <span>Menos</span>
 <div class="flex gap-1">
 <div class="w-2 h-2 bg-zinc-100 dark:bg-zinc-800"></div>
 <div class="w-2 h-2 bg-green-500"></div>
 </div>
 <span>Mais</span>
 </div>
 </div>

 <!-- Activity Bars -->
 <div class="space-y-3 w-full sm:w-auto min-w-[140px]">
 <!-- Run -->
 <div>
 <div class="flex justify-between text-xs mb-1">
 <span class="text-zinc-500"><i class="fas fa-running mr-1"></i> Corrida</span>
 <span
 class="font-bold text-zinc-900 dark:text-white">{{ $stats['recent_run_km'] }}km</span>
 </div>
 <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-1.5 overflow-hidden">
 <div class="bg-green-500 h-full "
 style="width: {{ $stats['recent_run_km'] > 0 ? '70%' : '5%' }}"></div>
 </div>
 </div>
 <!-- Cycle -->
 <div>
 <div class="flex justify-between text-xs mb-1">
 <span class="text-zinc-500"><i class="fas fa-bicycle mr-1"></i> Pedal</span>
 <span
 class="font-bold text-zinc-900 dark:text-white">{{ $stats['recent_ride_km'] }}km</span>
 </div>
 <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-1.5 overflow-hidden">
 <div class="bg-green-500 h-full "
 style="width: {{ $stats['recent_ride_km'] > 0 ? '50%' : '5%' }}"></div>
 </div>
 </div>
 </div>
 </div>
 </div>

 <!-- Tabs Navigation -->
 <div class="border-b border-zinc-200 dark:border-zinc-800 overflow-x-auto">
 <nav class="-mb-px flex space-x-8" aria-label="Tabs">
 @foreach(['Visão geral', 'Coleção de troféus', 'Seguindo', 'Publicações'] as $tab)
 <a href="#"
 class="{{ $loop->first ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 dark:text-zinc-400 dark:hover:text-zinc-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
 {{ $tab }}
 </a>
 @endforeach
 </nav>
 </div>

 <!-- Feed/Content Area -->
 <div>
 <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Conquistas Recentes</h3>
 <!-- Mock Achievements -->
 <div class="flex gap-4 overflow-x-auto pb-4 mb-8">
 <div
 class="flex items-center gap-3 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-100 dark:border-yellow-900/30 p-3 min-w-[250px]">
 <div
 class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-500">
 <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
 <path fill-rule="evenodd"
 d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
 clip-rule="evenodd" />
 </svg>
 </div>
 <div>
 <p class="text-sm font-bold text-zinc-900 dark:text-white">Recorde Pessoal 5k</p>
 <p class="text-xs text-zinc-500">22:30 • Há 2 dias</p>
 </div>
 </div>
 </div>

 <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Fotos Recentes</h3>
 <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mb-8">
 @for($i = 0; $i < 6; $i++)
 <div class="aspect-square bg-zinc-100 dark:bg-zinc-800 overflow-hidden">
 <img src="https://picsum.photos/seed/{{ $user->id + $i }}/200"
 class="w-full h-full object-cover hover:scale-110 transition-transform cursor-pointer">
 </div>
 @endfor
 </div>

 <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Atividades</h3>
 <!-- Re-use Activity Feed Component logic manually loop for now to avoid nesting active component issues if any -->
 <!-- Or just include the partial view if possible, but data is different. Let's loop manually simply -->
 <div class="space-y-6">
 @forelse($activities as $item)
 @if($item['type'] === 'post')
 <livewire:home.partials.post-item :post="$item['item']" :key="'profile-post-' . $item['item']->id" />
 @else
 <livewire:home.partials.activity-item :activity="$item['item']" :key="'profile-activity-' . $item['item']->id" />
 @endif
 @empty
 <div
 class="text-center py-12 bg-white dark:bg-zinc-900 border border-dashed border-zinc-200 dark:border-zinc-800">
 <p class="text-zinc-500 dark:text-zinc-400">Nenhuma atividade ou publicação recente para
 exibir.</p>
 </div>
 @endforelse
 </div>
 </div>

 </div>

 <!-- Right Sidebar -->
 <div class="lg:col-span-4 space-y-6">
 <!-- Social Stats -->
 <div
 class="bg-white dark:bg-zinc-900 p-6 shadow-sm border border-zinc-200 dark:border-zinc-800/50">
 <h3 class="font-bold text-zinc-900 dark:text-white mb-4">Estatísticas sociais</h3>
 <div class="grid grid-cols-2 gap-4">
 <div class="p-3 bg-zinc-50 dark:bg-zinc-800/50 ">
 <span class="block text-2xl font-bold text-zinc-900 dark:text-white">12</span>
 <span class="text-xs text-zinc-500">Seguindo</span>
 </div>
 <div class="p-3 bg-zinc-50 dark:bg-zinc-800/50 ">
 <span class="block text-2xl font-bold text-zinc-900 dark:text-white">450</span>
 <span class="text-xs text-zinc-500">Seguidores</span>
 </div>
 </div>
 </div>

 <!-- Clubs -->
 <div
 class="bg-white dark:bg-zinc-900 p-6 shadow-sm border border-zinc-200 dark:border-zinc-800/50">
 <h3 class="font-bold text-zinc-900 dark:text-white mb-4">Clubes</h3>
 <div class="space-y-3">
 <div
 class="flex items-center gap-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 p-2 transition-colors cursor-pointer">
 <img src="https://ui-avatars.com/api/?name=Run+Club&background=random"
 class="w-10 h-10 ">
 <div>
 <p class="text-sm font-bold text-zinc-900 dark:text-white">Clube de Corrida</p>
 <p class="text-xs text-zinc-500">12k membros</p>
 </div>
 </div>
 </div>
 </div>

 <!-- Comparison (Side by Side) -->
 <div
 class="bg-white dark:bg-zinc-900 p-6 shadow-sm border border-zinc-200 dark:border-zinc-800/50">
 <h3 class="font-bold text-zinc-900 dark:text-white mb-4">Comparação lado a lado</h3>
 <div class="flex items-center justify-between mb-4">
 <div class="flex -space-x-2">
 <img src="{{ auth()->user()->image_url }}"
 class="w-8 h-8 border-2 border-white dark:border-zinc-900">
 <img src="{{ $user->image_url }}"
 class="w-8 h-8 border-2 border-white dark:border-zinc-900">
 </div>
 <span class="text-xs font-semibold text-brand-600 cursor-pointer">Ver detalhado</span>
 </div>

 <div class="space-y-3 text-sm">
 <div class="flex justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
 <span class="text-zinc-500">Atividades (4 sem)</span>
 <div class="flex gap-4 font-mono text-xs">
 <span>{{ auth()->user()->activities()->count() }}</span>
 <span class="text-zinc-300">|</span>
 <span class="font-bold">{{ $stats['total_activities_last_4_weeks'] }}</span>
 </div>
 </div>
 <div class="flex justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
 <span class="text-zinc-500">Tempo (4 sem)</span>
 <div class="flex gap-4 font-mono text-xs">
 <span>12h</span>
 <span class="text-zinc-300">|</span>
 <span class="font-bold">14h</span>
 </div>
 </div>
 </div>
 </div>

 </div>
 </div>
 </div>
 <div class="min-h-screen pb-10 bg-zinc-50 dark:bg-zinc-900">
 
 <div class="relative w-full h-[200px] md:h-[350px]">
 <img src="https://socialv-wordpress.iqonic.design/wp-content/uploads/2022/10/cover-image.png" alt="Cover" class="w-full h-full object-cover">
 <button class="absolute top-4 right-4 md:top-6 md:right-6 bg-white p-2 md:p-2.5 shadow-md text-gray-500 hover:text-green-500 transition">
 <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
 </button>
 </div>

 <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 relative mt-[-50px] md:mt-[-80px]">
 
 <div class="bg-white shadow-sm px-4 md:px-6 pb-6 md:pb-8 pt-16 md:pt-6 relative flex flex-col items-center md:block">
 
 <div class="absolute -top-[50px] md:-top-[60px] left-1/2 transform -translate-x-1/2 flex flex-col items-center">
 <div class="relative">
 <img src="https://socialv-wordpress.iqonic.design/wp-content/uploads/2022/10/01.jpg" alt="Profile" class="w-[100px] h-[100px] md:w-[120px] md:h-[120px] border-4 border-white object-cover shadow-lg">
 <button class="absolute -top-1 -right-1 md:-top-2 md:-right-2 bg-green-500 text-white p-1 md:p-1.5 border-2 border-white shadow-sm">
 <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
 </button>
 </div>
 <span class="bg-emerald-400 text-white text-[10px] md:text-[11px] font-bold px-3 py-0.5 uppercase tracking-wider -mt-3 relative z-10 border-2 border-white">Online</span>
 </div>

 <div class="w-full flex flex-col md:flex-row md:justify-between items-center mt-2 md:mt-0 gap-6 md:gap-0">
 
 <div class="order-1 md:order-2 w-full md:w-1/3 flex flex-col items-center text-center mt-2 md:mt-8">
 <h1 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center justify-center gap-1">
 Marvin McKinney 
 <svg class="w-4 h-4 md:w-5 md:h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
 </h1>
 <div class="flex flex-wrap justify-center items-center gap-2 md:gap-4 text-[13px] md:text-sm text-gray-500 mt-2">
 <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> India Gujrat</span>
 <span class="hidden md:inline text-gray-300">|</span>
 <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg> www.iqonic.design</span>
 </div>
 </div>

 <div class="order-2 md:order-3 w-full md:w-1/3 flex justify-center md:justify-end gap-6 md:gap-8 text-center pt-2 md:pt-10">
 <div class="border-r border-gray-100 pr-6 md:border-none md:pr-0">
 <p class="text-lg md:text-xl font-bold text-gray-900">0</p>
 <p class="text-[12px] md:text-sm text-gray-400 font-medium tracking-wide">Posts</p>
 </div>
 <div class="border-r border-gray-100 pr-6 md:border-none md:pr-0">
 <p class="text-lg md:text-xl font-bold text-gray-900">0</p>
 <p class="text-[12px] md:text-sm text-gray-400 font-medium tracking-wide">Comments</p>
 </div>
 <div>
 <p class="text-lg md:text-xl font-bold text-gray-900">171.6K</p>
 <p class="text-[12px] md:text-sm text-gray-400 font-medium tracking-wide">Views</p>
 </div>
 </div>

 <div class="order-3 md:order-1 w-full md:w-1/3 flex flex-col items-center md:items-start gap-4 md:mt-10">
 <div class="flex flex-wrap justify-center md:justify-start items-center gap-3 text-sm font-semibold text-gray-800">
 <div class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 bg-yellow-400"></span> 9760 Coins</div>
 <div class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 bg-emerald-500"></span> 15770 Credits</div>
 <div class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rotate-45 bg-green-500"></span> <span class="ml-1">100 Gems</span></div>
 </div>
 <div class="flex justify-center md:justify-start gap-2">
 <a href="#" class="w-8 h-8 bg-green-600 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
 <a href="#" class="w-8 h-8 bg-sky-400 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
 <a href="#" class="w-8 h-8 bg-pink-500 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg></a>
 <a href="#" class="w-8 h-8 bg-green-700 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg></a>
 <a href="#" class="w-8 h-8 bg-red-600 text-white flex items-center justify-center hover:opacity-80"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
 </div>
 </div>

 </div>
 </div>

 <div class="bg-white mt-4 md:mt-6 shadow-sm px-2 md:px-4 py-2 relative">
 
 <div class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-white to-transparent z-10 hidden md:flex items-center justify-start pl-2 text-gray-400">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
 </div>

 <div class="flex overflow-x-auto hide-scrollbar snap-x items-center justify-start md:justify-between px-2 md:px-8">
 <button wire:click="setTab('timeline')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'timeline' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'timeline' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">Timeline</span>
 </button>
 <button wire:click="setTab('about')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'about' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'about' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">About</span>
 </button>
 <button wire:click="setTab('friends')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'friends' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'friends' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">Friends</span>
 </button>
 <button wire:click="setTab('notifications')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'notifications' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'notifications' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">Notifications</span>
 </button>
 <button wire:click="setTab('groups')" class="snap-start flex-shrink-0 flex flex-col items-center p-3 md:p-4 min-w-[90px] transition-colors {{ $activeTab === 'groups' ? 'text-green-500' : 'text-gray-500 hover:text-green-500' }}">
 <div class="p-2 md:p-2.5 mb-2 {{ $activeTab === 'groups' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-400' }}">
 <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
 </div>
 <span class="text-[12px] md:text-sm font-semibold">Groups</span>
 </button>
 </div>

 <div class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-white to-transparent z-10 hidden md:flex items-center justify-end pr-2 text-gray-400">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
 </div>
 </div>

 @if($activeTab === 'timeline')
 <div class="bg-white mt-4 md:mt-6 shadow-sm px-4 md:px-6 py-4 flex flex-col lg:flex-row justify-between lg:items-center gap-4">
 
 <div class="flex overflow-x-auto hide-scrollbar whitespace-nowrap gap-6 text-[13px] md:text-sm font-semibold text-gray-500 border-b border-gray-100 lg:border-none pb-2 lg:pb-0 w-full lg:w-auto">
 <button wire:click="setSubTab('all_update')" class="{{ $activeSubTab === 'all_update' ? 'text-gray-900 border-b-2 border-gray-900 pb-1' : 'hover:text-gray-900' }}">All Update</button>
 <button wire:click="setSubTab('mentions')" class="{{ $activeSubTab === 'mentions' ? 'text-gray-900 border-b-2 border-gray-900 pb-1' : 'hover:text-gray-900' }}">Mentions</button>
 <button wire:click="setSubTab('favorites')" class="{{ $activeSubTab === 'favorites' ? 'text-gray-900 border-b-2 border-gray-900 pb-1' : 'hover:text-gray-900' }}">Favorites</button>
 <button wire:click="setSubTab('friends')" class="{{ $activeSubTab === 'friends' ? 'text-gray-900 border-b-2 border-gray-900 pb-1' : 'hover:text-gray-900' }}">Friends</button>
 <button wire:click="setSubTab('scheduled')" class="{{ $activeSubTab === 'scheduled' ? 'text-gray-900 border-b-2 border-gray-900 pb-1' : 'hover:text-gray-900' }}">Scheduled Posts</button>
 <button wire:click="setSubTab('groups')" class="{{ $activeSubTab === 'groups' ? 'text-gray-900 border-b-2 border-gray-900 pb-1' : 'hover:text-gray-900' }}">Groups</button>
 </div>

 <div class="flex items-center justify-between lg:justify-end gap-2 w-full lg:w-auto mt-2 lg:mt-0 px-2 lg:px-0">
 <span class="text-sm font-semibold text-gray-500 whitespace-nowrap">Show:</span>
 <select wire:model.live="filterShow" class="bg-transparent border border-gray-200 text-gray-700 text-sm focus:ring-green-500 focus:border-green-500 block w-full lg:w-auto px-3 py-1.5 outline-none cursor-pointer">
 <option value="everything">— Everything —</option>
 <option value="updates">Updates</option>
 <option value="new_groups">New Groups</option>
 </select>
 </div>
 </div>
 @endif

 <div class="mt-4 md:mt-6">
 @if($activeTab === 'timeline')
 <div class="bg-transparent h-40 flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
 Conteúdo da Timeline ({{ $activeSubTab }})
 </div>
 @endif
 </div>

 </div>
 
 <style>
 .hide-scrollbar::-webkit-scrollbar {
 display: none;
 }
 .hide-scrollbar {
 -ms-overflow-style: none;
 scrollbar-width: none;
 }
 </style>
 </div>


</div>
