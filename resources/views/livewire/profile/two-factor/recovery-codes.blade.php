

<div class="py-6 space-y-6 border shadow-sm border-zinc-200 dark:border-white/10" wire:cloak
 x-data="{ showRecoveryCodes: false }">
 <div class="px-6 space-y-2">
 <div class="flex items-center gap-2">
 <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
 </path>
 </svg>
 <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ __('2FA Recovery Codes') }}</h3>
 </div>
 <p class="text-sm text-zinc-600 dark:text-zinc-400">
 {{ __('Recovery codes let you regain access if you lose your 2FA device. Store them in a secure password manager.') }}
 </p>
 </div>

 <div class="px-6">
 <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
 <button type="button" x-show="!showRecoveryCodes" @click="showRecoveryCodes = true;" aria-expanded="false"
 aria-controls="recovery-codes-section"
 class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
 {{ __('View Recovery Codes') }}
 </button>

 <button type="button" x-show="showRecoveryCodes" @click="showRecoveryCodes = false" aria-expanded="true"
 aria-controls="recovery-codes-section"
 class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
 {{ __('Hide Recovery Codes') }}
 </button>

 @if (filled($recoveryCodes))
 <button type="button" x-show="showRecoveryCodes" wire:click="regenerateRecoveryCodes"
 class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-500 font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150">
 {{ __('Regenerate Codes') }}
 </button>
 @endif
 </div>

 <div x-show="showRecoveryCodes" x-transition id="recovery-codes-section" class="relative overflow-hidden"
 x-bind:aria-hidden="!showRecoveryCodes">
 <div class="mt-3 space-y-3">
 @error('recoveryCodes')
 <div class="text-sm text-red-600 dark:text-red-400">{{$message}}</div>
 @enderror

 @if (filled($recoveryCodes))
 <div class="grid gap-1 p-4 font-mono text-sm bg-zinc-100 dark:bg-white/5" role="list"
 aria-label="Recovery codes">
 @foreach($recoveryCodes as $code)
 <div role="listitem" class="select-text" wire:loading.class="opacity-50 animate-pulse">
 {{ $code }}
 </div>
 @endforeach
 </div>
 <p class="text-xs text-zinc-500 dark:text-zinc-400">
 {{ __('Each recovery code can be used once to access your account and will be removed after use. If you need more, click Regenerate Codes above.') }}
 </p>
 @endif
 </div>
 </div>
 </div>
</div>