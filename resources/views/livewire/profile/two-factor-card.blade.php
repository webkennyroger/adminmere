

<div class="w-full">
    @if ($twoFactorEnabled)
        <div class="space-y-4">
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/20 dark:border-green-800">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h5 class="font-semibold text-green-800 dark:text-green-300">2FA Ativado</h5>
                </div>
                <p class="text-sm text-green-700 dark:text-green-400">
                    A autenticação de dois fatores está ativada. Você será solicitado a fornecer um código durante o login.
                </p>
            </div>

            <livewire:profile.two-factor.recovery-codes :$requiresConfirmation/>

            <button
                wire:click="disable"
                class="flex w-full justify-center rounded-lg bg-red-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-600 sm:w-auto"
            >
                Desativar 2FA
            </button>
        </div>
    @else
        <div class="space-y-4">
            <div class="p-4 bg-zinc-50 border border-zinc-200 rounded-lg dark:bg-zinc-800/50 dark:border-zinc-700">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                    Quando você ativa a autenticação de dois fatores, será solicitado um código seguro durante o login. Este código pode ser obtido de um aplicativo de autenticação no seu telefone.
                </p>
            </div>

            <button
                wire:click="enable"
                class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto"
            >
                Ativar 2FA
            </button>
        </div>
    @endif

    @if ($showSetup)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" wire:click.self="closeSetup">
            <div class="relative w-full max-w-md p-6 bg-white rounded-2xl dark:bg-zinc-900">
                <button @click="$wire.closeSetup()" class="absolute top-4 right-4 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="space-y-6">
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-zinc-800 dark:text-white/90">
                            {{ $showVerificationStep ? 'Verificar Código' : 'Configurar 2FA' }}
                        </h3>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $showVerificationStep ? 'Digite o código de 6 dígitos do seu aplicativo' : 'Escaneie o QR code ou digite a chave manualmente' }}
                        </p>
                    </div>

                    @if ($showVerificationStep)
                        <div class="space-y-4">
                            <input
                                type="text"
                                wire:model="code"
                                maxlength="6"
                                placeholder="000000"
                                class="w-full px-4 py-3 text-center text-2xl tracking-widest border border-zinc-300 rounded-lg dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            />
                            @error('code')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror

                            <div class="flex gap-3">
                                <button
                                    wire:click="resetVerification"
                                    class="flex-1 px-4 py-2.5 text-sm font-medium border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800"
                                >
                                    Voltar
                                </button>
                                <button
                                    wire:click="confirmTwoFactor"
                                    class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
                                >
                                    Confirmar
                                </button>
                            </div>
                        </div>
                    @else
                        @error('setupData')
                            <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/20 dark:text-red-400">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="flex justify-center">
                            <div class="p-4 bg-white rounded-lg border border-zinc-200">
                                @if($qrCodeSvg)
                                    {!! $qrCodeSvg !!}
                                @else
                                    <div class="w-48 h-48 flex items-center justify-center">
                                        <svg class="animate-spin h-8 w-8 text-zinc-400" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-zinc-200 dark:border-zinc-700"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white dark:bg-zinc-900 text-zinc-500">ou digite manualmente</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 p-3 bg-zinc-50 border border-zinc-200 rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            <input
                                type="text"
                                readonly
                                value="{{ $manualSetupKey }}"
                                class="flex-1 bg-transparent text-sm font-mono outline-none dark:text-white"
                            />
                            <button
                                onclick="navigator.clipboard.writeText('{{ $manualSetupKey }}')"
                                class="p-2 hover:bg-zinc-200 rounded dark:hover:bg-zinc-700"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>

                        <button
                            wire:click="showVerificationIfNecessary"
                            class="w-full px-4 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
                        >
                            Continuar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
