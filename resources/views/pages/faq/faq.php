@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Faq" />
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
 <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
 <h2 class="text-xl font-semibold text-zinc-800 dark:text-white/90">
 Faq
 </h2>
 <nav>
 <ol class="flex items-center gap-1.5">
 <li>
 <a class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400" href="https://laravel-demo.tailadmin.com">
 Home
 <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
 </svg>
 </a>
 </li>
 <li class="text-sm text-zinc-800 dark:text-white/90">
 Faq
 </li>
 </ol>
 </nav>
 </div>
 <div class="space-y-5 sm:space-y-6">
 <div class=" border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]">
 <!-- Card Header -->
 <div class="px-6 py-5">
 <h3 class="text-base font-medium text-zinc-800 dark:text-white/90">
 Faq 1
 </h3>
 </div>

 <!-- Card Body -->
 <div class="p-4 border-t border-zinc-100 dark:border-zinc-800 sm:p-6">
 <div class="space-y-6">
 <div x-data="faq()" class="space-y-4">
 <div class="overflow-hidden border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]" x-data="{ open: true }" @click.away="open = false">
 <!-- Header -->
 <div @click="open = !open" class="flex items-center justify-between py-3 pl-6 pr-3 cursor-pointer" :class="open ? 'bg-zinc-50 dark:bg-white/[0.03]' : ''">
 <h4 class="text-lg font-medium text-zinc-800 dark:text-white/90">
 Do I get free updates?
 </h4>

 <button :class="open 
 ? 'text-zinc-800 dark:text-white/90 rotate-180' 
 : 'text-zinc-500 dark:text-zinc-400'" class="flex h-12 w-full max-w-12 items-center justify-center bg-zinc-100 duration-200 ease-linear dark:bg-white/[0.03] transition-transform text-zinc-500 dark:text-zinc-400">
 <svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M5.75 8.875L12 15.125L18.25 8.875" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
 </svg>
 </button>
 </div>

 <!-- Body -->
 <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="px-6 py-7" style="display: none;">
 <p class="text-base text-zinc-500 dark:text-zinc-400">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 <div class="overflow-hidden border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]" x-data="{ open: false }" @click.away="open = false">
 <!-- Header -->
 <div @click="open = !open" class="flex items-center justify-between py-3 pl-6 pr-3 cursor-pointer" :class="open ? 'bg-zinc-50 dark:bg-white/[0.03]' : ''">
 <h4 class="text-lg font-medium text-zinc-800 dark:text-white/90">
 Do I get free updates?
 </h4>

 <button :class="open 
 ? 'text-zinc-800 dark:text-white/90 rotate-180' 
 : 'text-zinc-500 dark:text-zinc-400'" class="flex h-12 w-full max-w-12 items-center justify-center bg-zinc-100 duration-200 ease-linear dark:bg-white/[0.03] transition-transform text-zinc-500 dark:text-zinc-400">
 <svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M5.75 8.875L12 15.125L18.25 8.875" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
 </svg>
 </button>
 </div>

 <!-- Body -->
 <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="px-6 py-7" style="display: none;">
 <p class="text-base text-zinc-500 dark:text-zinc-400">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 <div class="overflow-hidden border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]" x-data="{ open: false }" @click.away="open = false">
 <!-- Header -->
 <div @click="open = !open" class="flex items-center justify-between py-3 pl-6 pr-3 cursor-pointer" :class="open ? 'bg-zinc-50 dark:bg-white/[0.03]' : ''">
 <h4 class="text-lg font-medium text-zinc-800 dark:text-white/90">
 Can I Customize TailAdmin to suit my needs?
 </h4>

 <button :class="open 
 ? 'text-zinc-800 dark:text-white/90 rotate-180' 
 : 'text-zinc-500 dark:text-zinc-400'" class="flex h-12 w-full max-w-12 items-center justify-center bg-zinc-100 duration-200 ease-linear dark:bg-white/[0.03] transition-transform text-zinc-500 dark:text-zinc-400">
 <svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M5.75 8.875L12 15.125L18.25 8.875" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
 </svg>
 </button>
 </div>

 <!-- Body -->
 <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="px-6 py-7" style="display: none;">
 <p class="text-base text-zinc-500 dark:text-zinc-400">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 <div class="overflow-hidden border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]" x-data="{ open: false }" @click.away="open = false">
 <!-- Header -->
 <div @click="open = !open" class="flex items-center justify-between py-3 pl-6 pr-3 cursor-pointer" :class="open ? 'bg-zinc-50 dark:bg-white/[0.03]' : ''">
 <h4 class="text-lg font-medium text-zinc-800 dark:text-white/90">
 What does "Unlimited Projects" mean?
 </h4>

 <button :class="open 
 ? 'text-zinc-800 dark:text-white/90 rotate-180' 
 : 'text-zinc-500 dark:text-zinc-400'" class="flex h-12 w-full max-w-12 items-center justify-center bg-zinc-100 duration-200 ease-linear dark:bg-white/[0.03] transition-transform text-zinc-500 dark:text-zinc-400">
 <svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M5.75 8.875L12 15.125L18.25 8.875" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
 </svg>
 </button>
 </div>

 <!-- Body -->
 <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="px-6 py-7" style="display: none;">
 <p class="text-base text-zinc-500 dark:text-zinc-400">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>
 <div class=" border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]">
 <!-- Card Header -->
 <div class="px-6 py-5">
 <h3 class="text-base font-medium text-zinc-800 dark:text-white/90">
 Faq 2
 </h3>
 </div>

 <!-- Card Body -->
 <div class="p-4 border-t border-zinc-100 dark:border-zinc-800 sm:p-6">
 <div class="space-y-6">
 <div class="grid grid-cols-1 gap-x-8 xl:grid-cols-2">
 <!-- First Column -->
 <div class="space-y-3">
 <div x-data="{ isOpen: true }" @click.away="open = false" class="overflow-hidden ">
 <div :class="isOpen ? 'bg-brand-50 dark:bg-brand-100' : 'bg-zinc-100 dark:bg-white/[0.03]'" class="transition-colors bg-zinc-100 dark:bg-white/[0.03]">
 <div @click="isOpen = !isOpen" class="flex items-center justify-between px-6 py-4 cursor-pointer">
 <h4 :class="isOpen ? 'text-zinc-800' : 'text-zinc-800 dark:text-white/90'" class="text-lg font-medium text-zinc-800 dark:text-white/90">
 Do I get free updates?
 </h4>

 <button :class="isOpen ? 'text-zinc-800 dark:text-zinc-800' : 'text-zinc-500 dark:text-zinc-400'" class="transition-colors text-zinc-500 dark:text-zinc-400">
 <!-- Plus Icon (when closed) -->
 <span x-show="!isOpen">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill=""></path>
 </svg>
 </span>

 <!-- Minus Icon (when open) -->
 <span x-show="isOpen" style="display: none;">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill=""></path>
 </svg>
 </span>
 </button>
 </div>

 <div x-show="isOpen" class="p-6 border-t border-brand-100 dark:border-brand-200" style="display: none;">
 <p class="text-base text-zinc-800">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 </div>
 <div x-data="{ isOpen: false }" @click.away="open = false" class="overflow-hidden ">
 <div :class="isOpen ? 'bg-brand-50 dark:bg-brand-100' : 'bg-zinc-100 dark:bg-white/[0.03]'" class="transition-colors bg-zinc-100 dark:bg-white/[0.03]">
 <div @click="isOpen = !isOpen" class="flex items-center justify-between px-6 py-4 cursor-pointer">
 <h4 :class="isOpen ? 'text-zinc-800' : 'text-zinc-800 dark:text-white/90'" class="text-lg font-medium text-zinc-800 dark:text-white/90">
 Which license type is suitable for me?
 </h4>

 <button :class="isOpen ? 'text-zinc-800 dark:text-zinc-800' : 'text-zinc-500 dark:text-zinc-400'" class="transition-colors text-zinc-500 dark:text-zinc-400">
 <!-- Plus Icon (when closed) -->
 <span x-show="!isOpen">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill=""></path>
 </svg>
 </span>

 <!-- Minus Icon (when open) -->
 <span x-show="isOpen" style="display: none;">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill=""></path>
 </svg>
 </span>
 </button>
 </div>

 <div x-show="isOpen" class="p-6 border-t border-brand-100 dark:border-brand-200" style="display: none;">
 <p class="text-base text-zinc-800">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 </div>
 <div x-data="{ isOpen: false }" @click.away="open = false" class="overflow-hidden ">
 <div :class="isOpen ? 'bg-brand-50 dark:bg-brand-100' : 'bg-zinc-100 dark:bg-white/[0.03]'" class="transition-colors bg-zinc-100 dark:bg-white/[0.03]">
 <div @click="isOpen = !isOpen" class="flex items-center justify-between px-6 py-4 cursor-pointer">
 <h4 :class="isOpen ? 'text-zinc-800' : 'text-zinc-800 dark:text-white/90'" class="text-lg font-medium text-zinc-800 dark:text-white/90">
 What are the "Seats" mentioned on pricing plans?
 </h4>

 <button :class="isOpen ? 'text-zinc-800 dark:text-zinc-800' : 'text-zinc-500 dark:text-zinc-400'" class="transition-colors text-zinc-500 dark:text-zinc-400">
 <!-- Plus Icon (when closed) -->
 <span x-show="!isOpen">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill=""></path>
 </svg>
 </span>

 <!-- Minus Icon (when open) -->
 <span x-show="isOpen" style="display: none;">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill=""></path>
 </svg>
 </span>
 </button>
 </div>

 <div x-show="isOpen" class="p-6 border-t border-brand-100 dark:border-brand-200" style="display: none;">
 <p class="text-base text-zinc-800">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 </div>
 </div>

 <!-- Second Column -->
 <div class="space-y-3">
 <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="overflow-hidden ">
 <div :class="isOpen ? 'bg-brand-50 dark:bg-brand-100' : 'bg-zinc-100 dark:bg-white/[0.03]'" class="transition-colors bg-zinc-100 dark:bg-white/[0.03]">
 <div @click="isOpen = !isOpen" class="flex items-center justify-between px-6 py-4 cursor-pointer">
 <h4 :class="isOpen ? 'text-zinc-800' : 'text-zinc-800 dark:text-white/90'" class="text-lg font-medium text-zinc-800 dark:text-white/90">
 Can I Customize TailAdmin to suit my needs?
 </h4>

 <button :class="isOpen ? 'text-zinc-800 dark:text-zinc-800' : 'text-zinc-500 dark:text-zinc-400'" class="transition-colors text-zinc-500 dark:text-zinc-400">
 <!-- Plus Icon (when closed) -->
 <span x-show="!isOpen">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill=""></path>
 </svg>
 </span>

 <!-- Minus Icon (when open) -->
 <span x-show="isOpen" style="display: none;">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill=""></path>
 </svg>
 </span>
 </button>
 </div>

 <div x-show="isOpen" class="p-6 border-t border-brand-100 dark:border-brand-200" style="display: none;">
 <p class="text-base text-zinc-800">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 </div>
 <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="overflow-hidden ">
 <div :class="isOpen ? 'bg-brand-50 dark:bg-brand-100' : 'bg-zinc-100 dark:bg-white/[0.03]'" class="transition-colors bg-zinc-100 dark:bg-white/[0.03]">
 <div @click="isOpen = !isOpen" class="flex items-center justify-between px-6 py-4 cursor-pointer">
 <h4 :class="isOpen ? 'text-zinc-800' : 'text-zinc-800 dark:text-white/90'" class="text-lg font-medium text-zinc-800 dark:text-white/90">
 What does "Unlimited Projects" mean?
 </h4>

 <button :class="isOpen ? 'text-zinc-800 dark:text-zinc-800' : 'text-zinc-500 dark:text-zinc-400'" class="transition-colors text-zinc-500 dark:text-zinc-400">
 <!-- Plus Icon (when closed) -->
 <span x-show="!isOpen">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill=""></path>
 </svg>
 </span>

 <!-- Minus Icon (when open) -->
 <span x-show="isOpen" style="display: none;">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill=""></path>
 </svg>
 </span>
 </button>
 </div>

 <div x-show="isOpen" class="p-6 border-t border-brand-100 dark:border-brand-200" style="display: none;">
 <p class="text-base text-zinc-800">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 </div>
 <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="overflow-hidden ">
 <div :class="isOpen ? 'bg-brand-50 dark:bg-brand-100' : 'bg-zinc-100 dark:bg-white/[0.03]'" class="transition-colors bg-zinc-100 dark:bg-white/[0.03]">
 <div @click="isOpen = !isOpen" class="flex items-center justify-between px-6 py-4 cursor-pointer">
 <h4 :class="isOpen ? 'text-zinc-800' : 'text-zinc-800 dark:text-white/90'" class="text-lg font-medium text-zinc-800 dark:text-white/90">
 Can I upgrade to a higher plan?
 </h4>

 <button :class="isOpen ? 'text-zinc-800 dark:text-zinc-800' : 'text-zinc-500 dark:text-zinc-400'" class="transition-colors text-zinc-500 dark:text-zinc-400">
 <!-- Plus Icon (when closed) -->
 <span x-show="!isOpen">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill=""></path>
 </svg>
 </span>

 <!-- Minus Icon (when open) -->
 <span x-show="isOpen" style="display: none;">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill=""></path>
 </svg>
 </span>
 </button>
 </div>

 <div x-show="isOpen" class="p-6 border-t border-brand-100 dark:border-brand-200" style="display: none;">
 <p class="text-base text-zinc-800">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 </div>
 <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="overflow-hidden ">
 <div :class="isOpen ? 'bg-brand-50 dark:bg-brand-100' : 'bg-zinc-100 dark:bg-white/[0.03]'" class="transition-colors bg-zinc-100 dark:bg-white/[0.03]">
 <div @click="isOpen = !isOpen" class="flex items-center justify-between px-6 py-4 cursor-pointer">
 <h4 :class="isOpen ? 'text-zinc-800' : 'text-zinc-800 dark:text-white/90'" class="text-lg font-medium text-zinc-800 dark:text-white/90">
 Are there dark and light mode options?
 </h4>

 <button :class="isOpen ? 'text-zinc-800 dark:text-zinc-800' : 'text-zinc-500 dark:text-zinc-400'" class="transition-colors text-zinc-500 dark:text-zinc-400">
 <!-- Plus Icon (when closed) -->
 <span x-show="!isOpen">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill=""></path>
 </svg>
 </span>

 <!-- Minus Icon (when open) -->
 <span x-show="isOpen" style="display: none;">
 <svg class="fill-current" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill=""></path>
 </svg>
 </span>
 </button>
 </div>

 <div x-show="isOpen" class="p-6 border-t border-brand-100 dark:border-brand-200" style="display: none;">
 <p class="text-base text-zinc-800">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.
 </p>
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>
 <div class=" border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]">
 <!-- Card Header -->
 <div class="px-6 py-5">
 <h3 class="text-base font-medium text-zinc-800 dark:text-white/90">
 Faq 3
 </h3>
 </div>

 <!-- Card Body -->
 <div class="p-4 border-t border-zinc-100 dark:border-zinc-800 sm:p-6">
 <div class="space-y-6">
 <div class="gird-cols-1 grid gap-x-8 xl:grid-cols-2">
 <div class="space-y-3 sm:space-y-5">
 <!-- item -->
 <div class="py-4">
 <div class="flex items-start gap-4">
 <div class="text-zinc-700 dark:text-zinc-500">
 <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
 </svg>
 </div>

 <div>
 <h4 class="mb-3 text-lg font-medium text-zinc-800 dark:text-white/90">
 Do I get free updates?
 </h4>

 <p class="text-base text-zinc-500 dark:text-zinc-400">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et nunc ut risus imperdiet lacinia.<br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 </p>
 </div>
 </div>
 </div>

 <!-- divider -->
 <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>
 <!-- item -->
 <div class="py-4">
 <div class="flex items-start gap-4">
 <div class="text-zinc-700 dark:text-zinc-500">
 <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
 </svg>
 </div>

 <div>
 <h4 class="mb-3 text-lg font-medium text-zinc-800 dark:text-white/90">
 Which license type is suitable for me?
 </h4>

 <p class="text-base text-zinc-500 dark:text-zinc-400">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 </p>
 </div>
 </div>
 </div>

 <!-- divider -->
 <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>
 <!-- item -->
 <div class="py-4">
 <div class="flex items-start gap-4">
 <div class="text-zinc-700 dark:text-zinc-500">
 <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
 </svg>
 </div>

 <div>
 <h4 class="mb-3 text-lg font-medium text-zinc-800 dark:text-white/90">
 What are the "Seats" mentioned on pricing plans?
 </h4>

 <p class="text-base text-zinc-500 dark:text-zinc-400">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et nunc ut risus imperdiet lacinia.
 </p>
 </div>
 </div>
 </div>

 <!-- divider -->
 </div>
 <div class="space-y-3 sm:space-y-5">
 <!-- item -->
 <div class="py-4">
 <div class="flex items-start gap-4">
 <div class="text-zinc-700 dark:text-zinc-500">
 <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
 </svg>
 </div>

 <div>
 <h4 class="mb-3 text-lg font-medium text-zinc-800 dark:text-white/90">
 Can I Customize TailAdmin to suit my needs?
 </h4>

 <p class="text-base text-zinc-500 dark:text-zinc-400">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et nunc ut risus imperdiet lacinia.<br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 </p>
 </div>
 </div>
 </div>

 <!-- divider -->
 <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>
 <!-- item -->
 <div class="py-4">
 <div class="flex items-start gap-4">
 <div class="text-zinc-700 dark:text-zinc-500">
 <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
 </svg>
 </div>

 <div>
 <h4 class="mb-3 text-lg font-medium text-zinc-800 dark:text-white/90">
 What does "Unlimited Projects" mean?
 </h4>

 <p class="text-base text-zinc-500 dark:text-zinc-400">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fermentum, leo et lacinia accumsan, ligula ante hendrerit nisi, eget vulputate ante justo et justo.
 </p>
 </div>
 </div>
 </div>

 <!-- divider -->
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>
</div>
@endsection