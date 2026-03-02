<div>
 <x-common.page-breadcrumb title="Planos de Assinatura" />

 <div class=" border border-zinc-200 bg-white pt-4 dark:border-zinc-800 dark:bg-white/3">
 <!-- Header -->
 <div class="flex flex-col gap-2 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
 <div class="flex items-center gap-3">
 <span class="text-zinc-500 dark:text-zinc-400">Mostrar</span>
 <span class="text-zinc-500 dark:text-zinc-400">Planos</span>
 </div>

 <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
 <button wire:click="create"
 class="flex items-center justify-center bg-green-600 hover:bg-green-500 text-white h-9 px-4 py-2 text-sm font-medium transition-colors">
 Novo Plano
 </button>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-hidden">
 <div class="max-w-full px-5 overflow-x-auto">
 <table class="min-w-full">
 <thead class="border-t border-zinc-100 border-y bg-zinc-50 dark:bg-zinc-900">
 <tr class="border-zinc-200 border-y dark:border-zinc-700">
 <th scope="col"
 class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
 Nome</th>
 <th scope="col"
 class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
 Preço</th>
 <th scope="col"
 class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
 Período</th>
 <th scope="col"
 class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
 Stripe ID</th>
 <th scope="col"
 class="px-4 py-3 font-normal text-zinc-500 text-center text-theme-sm dark:text-zinc-400">
 Status</th>
 <th scope="col"
 class="px-4 py-3 font-normal text-zinc-500 text-center text-theme-sm dark:text-zinc-400">
 Ações</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
 @forelse($plans as $plan)
 <tr wire:key="{{ $plan->id }}">
 <td class="px-6 py-4 whitespace-nowrap">
 <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ $plan->name }}
 </div>
 </td>
 <td class="px-6 py-4 whitespace-nowrap">
 <div class="text-sm font-medium text-green-500">{{ $plan->formatted_price }}</div>
 </td>
 <td class="px-4 py-4 whitespace-nowrap">
 <div class="text-sm text-zinc-500 dark:text-zinc-400">
 {{ ucfirst($plan->billing_period) }}
 </div>
 </td>
 <td class="px-4 py-4 whitespace-nowrap">
 <div class="text-xs font-mono text-zinc-500 dark:text-zinc-400">
 {{ $plan->stripe_plan_id }}
 </div>
 </td>
 <td class="px-4 py-4 whitespace-nowrap text-center">
 @if($plan->is_active)
 <span
 class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Ativo</span>
 @else
 <span
 class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Inativo</span>
 @endif
 </td>
 <td class="px-4 py-4 text-sm font-medium text-center whitespace-nowrap">
 <div class="flex justify-center gap-2">
 <button wire:click="edit({{ $plan->id }})"
 class="inline-flex items-center justify-center gap-2 p-2 text-green-600 bg-green-600/10 hover:bg-green-600/20">
 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
 stroke-linecap="round" stroke-linejoin="round"
 class="lucide lucide-square-pen">
 <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
 <path
 d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z">
 </path>
 </svg>
 </button>
 <button wire:click="confirmDelete({{ $plan->id }})"
 class="inline-flex items-center justify-center gap-2 p-2 text-red-600 bg-red-600/10 hover:bg-red-600/20">
 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
 stroke-linecap="round" stroke-linejoin="round"
 class="lucide lucide-trash-2">
 <path d="M3 6h18"></path>
 <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
 <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
 <line x1="10" x2="10" y1="11" y2="17"></line>
 <line x1="14" x2="14" y1="11" y2="17"></line>
 </svg>
 </button>
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="6" class="p-4 text-center text-zinc-500">Nenhum plano encontrado.</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 </div>

 <div class="p-4"></div>
 </div>

 {{-- Create / Edit Modal --}}
 @if($showModal)
 <div class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50"
 wire:click="closeModal" x-transition>
 <div class="bg-white dark:bg-zinc-900 p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto"
 wire:click.stop>
 <div class="flex justify-between items-center mb-4">
 <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
 {{ $isEditMode ? 'Editar Plano' : 'Novo Plano' }}
 </h3>
 <button wire:click="closeModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
 </path>
 </svg>
 </button>
 </div>

 <form wire:submit="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-6">
 <div>
 <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Nome do Plano
 *</label>
 <input wire:model="name" type="text"
 class="w-full border px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
 @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
 </div>

 <div>
 <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Preço (em centavos)
 *</label>
 <input wire:model="price" type="number"
 class="w-full border px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
 @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
 </div>

 <div>
 <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Stripe ID Plan
 *</label>
 <input wire:model="stripe_plan_id" type="text"
 class="w-full border px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
 @error('stripe_plan_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
 </div>

 <div>
 <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Período de Cobrança
 *</label>
 <select wire:model="billing_period"
 class="w-full border px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
 <option value="monthly">Mensal</option>
 <option value="yearly">Anual</option>
 </select>
 @error('billing_period') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
 </div>

 <div>
 <label
 class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Funcionalidades</label>
 <textarea wire:model="features"
 class="w-full border px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100"
 rows="3"></textarea>
 @error('features') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
 </div>

 <div class="flex items-center">
 <input wire:model="is_active" type="checkbox" id="modal_is_active"
 class="w-4 h-4 text-brand-600 bg-zinc-100 border-zinc-300 focus:ring-brand-500 dark:focus:ring-brand-600 dark:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
 <label for="modal_is_active" class="ml-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Plano
 Ativo</label>
 </div>

 <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
 <button type="button" wire:click="closeModal"
 class="px-4 py-2 bg-zinc-200 text-zinc-800 hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200">Cancelar</button>
 <button type="submit" class="px-4 py-2 bg-green-600 text-white hover:bg-green-700">
 {{ $isEditMode ? 'Salvar Alterações' : 'Criar Plano' }}
 </button>
 </div>
 </form>
 </div>
 </div>
 @endif

 {{-- Modal de Confirmação de Exclusão --}}
 @if($confirmingDeletion)
 <div class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50"
 wire:click="$set('confirmingDeletion', false)">
 <div class="bg-white dark:bg-zinc-900 p-6 max-w-md w-full mx-4" wire:click.stop>
 <div class="flex items-center gap-4 mb-4">
 <div
 class="shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
 <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
 viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
 </svg>
 </div>
 <div class="flex-1">
 <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Confirmar Exclusão</h3>
 <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
 Tem certeza que deseja excluir o plano "<strong>{{ $planToDelete?->name }}</strong>"?
 </p>
 </div>
 </div>

 <div class="flex justify-end gap-3 pt-5">
 <button type="button" wire:click="$set('confirmingDeletion', false)"
 class="px-4 py-2 bg-zinc-200 text-zinc-800 hover:bg-zinc-300">Cancelar</button>
 <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white hover:bg-red-700">Sim,
 Excluir</button>
 </div>
 </div>
 </div>
 @endif
</div>