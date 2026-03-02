@props(['digits' => 6, 'name', 'value' => ''])

<div x-data="{
 length: {{ $digits }},
 value: $wire.entangle('{{ $attributes->wire('model')->value() }}'),
 }" class="flex gap-2 justify-center">
 <div class="relative w-full text-center">
 <input type="text" maxlength="{{ $digits }}" x-model="value"
 class="w-full text-center tracking-[1em] text-lg font-bold border-stone-200 dark:border-stone-700 focus:ring-green-500 focus:border-green-500 bg-white dark:bg-stone-900"
 placeholder="000000" {{ $attributes->whereDoesntStartWith('wire:model') }} />
 <p class="mt-2 text-xs text-stone-500 dark:text-stone-400">
 Digite o código de {{ $digits }} dígitos
 </p>
 </div>
</div>