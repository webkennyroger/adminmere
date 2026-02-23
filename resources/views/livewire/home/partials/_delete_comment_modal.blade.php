<x-ui.modal wire:model="confirmingCommentDeletion" :maxWidth="'sm:max-w-md'" :showCloseButton="false"
    wire:key="delete-comment-modal-{{ $item->id }}">
    <div class="px-4 py-8 sm:px-14 text-center">
        <div
            class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/20 mb-4">
            <svg class="h-6 w-6 text-red-600 dark:text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-neutral-200">
            Apagar Comentário
        </h3>
        <p class="text-gray-500 dark:text-neutral-400">
            Tem certeza que deseja remover este comentário? Esta ação não pode ser desfeita.
        </p>
    </div>

    <div class="flex items-center">
        <button type="button" wire:click="cancelDelete"
            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-es-xl border border-transparent bg-gray-100 dark:bg-neutral-700 text-[#FFC107] hover:bg-gray-200 dark:hover:bg-neutral-600 focus:outline-hidden disabled:opacity-50 transition-all">
            Cancelar
        </button>
        <button type="button" wire:click="deleteComment"
            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-ee-xl bg-red-500 border border-transparent text-white hover:bg-red-600 focus:outline-hidden disabled:opacity-50 transition-all">
            Apagar
        </button>
    </div>
</x-ui.modal>