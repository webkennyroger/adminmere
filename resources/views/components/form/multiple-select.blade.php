@props([
 'options' => [],
 'label' => '',
 'placeholder' => 'Selecione...',
 'multiple' => true,
 'id' => null,
 'name' => null,
])

<div class="relative w-full">
 @if($label)
 <label @if($id) for="{{ $id }}" @endif class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-400">
 {{ $label }}
 </label>
 @endif

 <div x-data="{
 open: false,
 multiple: {{ $multiple ? 'true' : 'false' }},
 selected: @if($attributes->wire('model')->value()) @entangle($attributes->wire('model')) @else '{{ $attributes->get('value') }}' @endif,
 options: @js($options),
 search: '',
 
 init() {
 if (!this.multiple && !this.selected && this.options.length > 0) {
 // Optional: Select first option if nothing selected? No, respect placeholder.
 }
 },
 
 get displayOptions() {
 if (!this.search) return this.options;
 return this.options.filter(option => 
 option.label.toLowerCase().includes(this.search.toLowerCase())
 );
 },

 get selectedLabel() {
 if (this.multiple) return '';
 const option = this.options.find(o => o.value == this.selected);
 return option ? option.label : '';
 },

 toggleOption(value) {
 if (this.multiple) {
 if (!Array.isArray(this.selected)) this.selected = [];
 if (this.selected.includes(value)) {
 this.selected = this.selected.filter(i => i != value);
 } else {
 this.selected.push(value);
 }
 } else {
 this.selected = value;
 this.open = false;
 }
 },

 isSelected(value) {
 if (this.multiple) {
 return Array.isArray(this.selected) && this.selected.includes(value);
 } else {
 return this.selected == value;
 }
 },

 removeSelection(value) {
 if (this.multiple && Array.isArray(this.selected)) {
 this.selected = this.selected.filter(i => i != value);
 }
 }
 }" 
 class="relative" 
 @click.away="open = false"
 @if($id) id="{{ $id }}" @endif>
 
 @if($name)
 <input type="hidden" name="{{ $name }}" :value="multiple ? JSON.stringify(selected) : selected">
 @endif
 
 <!-- Trigger -->
 <div @click="open = !open"
 class="shadow-theme-xs flex min-h-[44px] w-full cursor-pointer items-center justify-between gap-2 border border-zinc-300 bg-white px-3 py-2 transition dark:border-zinc-700 dark:bg-zinc-900">
 
 <div class="flex flex-1 flex-wrap items-center gap-2">
 <!-- Multiple Mode: Tags -->
 <template x-if="multiple && Array.isArray(selected) && selected.length > 0">
 <div class="flex flex-wrap gap-2">
 <template x-for="value in selected" :key="value">
 <div class="group flex items-center justify-center border-[0.7px] border-transparent bg-zinc-100 py-0.5 px-2 text-sm text-zinc-800 dark:bg-zinc-800 dark:text-white/90">
 <span x-text="options.find(o => o.value == value)?.label || value"></span>
 <button type="button" @click.stop="removeSelection(value)"
 class="ml-1 text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300">
 <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
 </button>
 </div>
 </template>
 </div>
 </template>

 <!-- Single Mode: Text -->
 <template x-if="!multiple && selected">
 <span class="text-sm text-zinc-800 dark:text-zinc-200" x-text="selectedLabel"></span>
 </template>

 <!-- Placeholder -->
 <span x-show="(multiple && (!selected || selected.length === 0)) || (!multiple && !selected)" 
 class="text-sm text-zinc-500 dark:text-zinc-400">
 {{ $placeholder }}
 </span>
 </div>

 <!-- Arrow -->
 <div class="flex items-center">
 <svg class="h-5 w-5 text-zinc-500 transition-transform dark:text-zinc-400"
 :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
 </svg>
 </div>
 </div>

 <!-- Dropdown -->
 <div x-show="open"
 x-transition:enter="transition ease-out duration-100"
 x-transition:enter-start="opacity-0 scale-95"
 x-transition:enter-end="opacity-100 scale-100"
 x-transition:leave="transition ease-in duration-75"
 x-transition:leave-start="opacity-100 scale-100"
 x-transition:leave-end="opacity-0 scale-95"
 class="absolute z-50 mt-1 w-full overflow-hidden border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-900"
 style="display: none;">
 
 <div class="max-h-60 overflow-y-auto">
 <template x-for="option in options" :key="option.value">
 <div @click="toggleOption(option.value)"
 class="cursor-pointer border-b border-zinc-100 px-4 py-2.5 text-sm transition last:border-b-0 hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/50"
 :class="isSelected(option.value) ? 'bg-zinc-50 dark:bg-zinc-800/50' : ''">
 <div class="flex items-center justify-between">
 <span class="text-zinc-800 dark:text-zinc-200" x-text="option.label"></span>
 <template x-if="isSelected(option.value)">
 <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
 </svg>
 </template>
 </div>
 </div>
 </template>
 <div x-show="options.length === 0" class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 text-center">
 Nenhuma opção encontrada.
 </div>
 </div>
 </div>
 </div>
</div>
