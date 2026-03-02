<x-layouts.app>
 <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

 <!-- Page Header -->
 <div class="mb-8">
 <h1 class="text-2xl md:text-3xl text-zinc-800 dark:text-zinc-100 font-bold">Minha Assinatura</h1>
 </div>

 <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

 <!-- Current Subscription Status -->
 <div class="lg:col-span-2 space-y-6">

 <!-- Active Subscription Card -->
 <div
 class="bg-white dark:bg-zinc-800 shadow-lg border border-zinc-200 dark:border-zinc-700 p-5">
 <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-4">Status da Assinatura</h2>

 @if(session('success'))
 <div class="mb-4 p-3 bg-green-100 text-green-700 text-sm">
 {{ session('success') }}
 </div>
 @endif

 @if($user->subscribed('default'))
 <div class="flex items-center justify-between mb-4">
 <div>
 <div class="text-sm text-zinc-500 font-medium">Plano Atual</div>
 <div class="text-xl font-bold text-indigo-500">
 {{ $user->subscription('default')->stripe_price ? 'Assinatura Ativa' : 'Plano Personalizado' }}
 </div>
 @if($user->subscription('default')->onGracePeriod())
 <div class="text-xs text-orange-500 font-medium mt-1">Cancelado (Acesso até
 {{ $user->subscription('default')->ends_at->format('d/m/Y') }})</div>
 @else
 <div class="text-xs text-zinc-400 mt-1">Renova em
 {{ $user->subscription('default')->asStripeSubscription()->current_period_end ? \Carbon\Carbon::createFromTimestamp($user->subscription('default')->asStripeSubscription()->current_period_end)->format('d/m/Y') : 'Data desconhecida' }}
 </div>
 @endif
 </div>
 <div>
 @if($user->subscription('default')->onGracePeriod())
 <form action="{{ route('billing.resume') }}" method="POST">
 @csrf
 <button type="submit" class="btn bg-green-500 hover:bg-green-600 text-white">Reativar
 Assinatura</button>
 </form>
 @else
 <form action="{{ route('billing.cancel') }}" method="POST"
 onsubmit="return confirm('Tem certeza que deseja cancelar?');">
 @csrf
 <button type="submit"
 class="btn bg-red-500 hover:bg-red-600 text-white">Cancelar</button>
 </form>
 @endif
 </div>
 </div>

 <div class="border-t border-zinc-100 dark:border-zinc-700 pt-4 mt-4">
 <a href="{{ route('billing.portal') }}"
 class="text-indigo-500 hover:text-indigo-600 font-medium text-sm flex items-center">
 Gerenciar Método de Pagamento e Faturas
 <svg class="w-3 h-3 ml-1 fill-current" viewBox="0 0 12 12">
 <path
 d="M6.602 11l-.875-.864L9.33 6.534H0v-1.25h9.33L5.727 1.693l.875-.875 5.091 5.091z" />
 </svg>
 </a>
 </div>

 @else
 <div class="text-center py-8">
 <div class="text-zinc-500 mb-4">Você ainda não possui uma assinatura ativa.</div>
 <div class="text-sm text-zinc-400">Escolha um plano ao lado para começar.</div>
 </div>
 @endif
 </div>

 <!-- Payment History (Invoices) -->
 <div
 class="bg-white dark:bg-zinc-800 shadow-lg border border-zinc-200 dark:border-zinc-700 p-5">
 <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-4">Histórico de Pagamentos</h2>

 <div class="overflow-x-auto">
 <table class="table-auto w-full text-sm text-left">
 <thead
 class="text-zinc-500 dark:text-zinc-400 font-medium border-b border-zinc-100 dark:border-zinc-700">
 <tr>
 <th class="py-2">Data</th>
 <th class="py-2">Valor</th>
 <th class="py-2">Status</th>
 <th class="py-2 text-right">Fatura</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
 @forelse($user->invoices() as $invoice)
 <tr>
 <td class="py-3 text-zinc-800 dark:text-zinc-100">
 {{ $invoice->date()->toFormattedDateString() }}</td>
 <td class="py-3">{{ $invoice->total() }}</td>
 <td class="py-3">
 @if($invoice->paid)
 <span class="text-green-500 font-medium">Pago</span>
 @else
 <span class="text-orange-500 font-medium">Pendente</span>
 @endif
 </td>
 <td class="py-3 text-right">
 <a href="{{ $invoice->hosted_invoice_url }}" target="_blank"
 class="text-indigo-500 hover:text-indigo-600">Ver Fatura</a>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="4" class="py-4 text-center text-zinc-500">Nenhum pagamento registrado.
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 </div>

 </div>

 <!-- Available Plans -->
 <div class="space-y-6">
 <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Planos Disponíveis</h3>

 @foreach($plans as $plan)
 <div
 class="bg-white dark:bg-zinc-800 shadow-lg border border-zinc-200 dark:border-zinc-700 p-5 flex flex-col h-full relative overflow-hidden">
 @if($user->subscribedToPrice($plan->stripe_plan_id, 'default'))
 <div
 class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-3 py-1 ">
 Atual</div>
 @endif

 <div class="mb-4">
 <h4 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">{{ $plan->name }}</h4>
 <div class="text-2xl font-bold text-indigo-500 mt-2">{{ $plan->formatted_price }} <span
 class="text-sm font-medium text-zinc-400">/
 {{ $plan->billing_period == 'monthly' ? 'mês' : 'ano' }}</span></div>
 </div>

 <div class="grow">
 <ul class="text-sm text-zinc-600 dark:text-zinc-400 space-y-2 mb-6">
 @foreach($plan->features ?? [] as $feature)
 <li class="flex items-center">
 <svg class="w-3 h-3 fill-current text-green-500 mr-2 shrink-0" viewBox="0 0 12 12">
 <path
 d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
 </svg>
 <span>{{ trim($feature) }}</span>
 </li>
 @endforeach
 </ul>
 </div>

 <div class="mt-auto">
 @if(!$user->subscribedToPrice($plan->stripe_plan_id, 'default'))
 <a href="{{ route('billing.subscribe', $plan->id) }}"
 class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white">
 {{ $user->subscribed('default') ? 'Trocar para este Plano' : 'Assinar' }}
 </a>
 @else
 <button disabled class="btn w-full border-zinc-200 text-zinc-400 cursor-not-allowed">
 Plano Atual
 </button>
 @endif
 </div>
 </div>
 @endforeach
 </div>
 </div>

 </div>
</x-layouts.app>