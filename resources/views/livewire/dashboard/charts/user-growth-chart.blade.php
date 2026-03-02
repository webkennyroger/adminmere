<div class=" border border-zinc-200 bg-white px-5 pb-5 pt-5 dark:border-zinc-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6"
 x-data="{
 chart: null,
 initChart() {
 if (typeof ApexCharts === 'undefined') {
 console.error('ApexCharts não carregado!');
 return;
 }

 const usersData = @js($usersChartValues);
 const subscribersData = @js($subscribersChartValues);
 const chartLabels = @js($chartLabels);
 
 const options = {
 series: [
 {
 name: 'Usuários',
 data: usersData,
 color: '#4c4ee7'
 },
 {
 name: 'Assinantes',
 data: subscribersData,
 color: '#0ea5e9'
 }
 ],
 chart: {
 type: 'bar',
 height: 260,
 toolbar: { show: false },
 fontFamily: 'inherit',
 },
 plotOptions: {
 bar: {
 borderRadius: 4,
 columnWidth: '55%',
 }
 },
 dataLabels: { enabled: false },
 stroke: {
 show: true,
 width: 2,
 colors: ['transparent']
 },
 xaxis: {
 categories: chartLabels,
 labels: {
 style: {
 colors: '#9ca3af',
 fontSize: '12px'
 }
 }
 },
 yaxis: {
 labels: { show: false }
 },
 grid: {
 borderColor: '#e5e7eb',
 strokeDashArray: 0,
 },
 legend: {
 show: true,
 position: 'top',
 horizontalAlign: 'right',
 markers: {
 width: 10,
 height: 10,
 radius: 2,
 }
 },
 tooltip: {
 y: {
 formatter: function (val, { seriesIndex }) {
 return val + (seriesIndex === 0 ? ' usuários' : ' assinantes');
 }
 }
 }
 };

 if (this.chart) {
 this.chart.destroy();
 }
 
 this.chart = new ApexCharts(document.querySelector('#userGrowthChart'), options);
 this.chart.render();
 }
 }" x-init="$nextTick(() => initChart())" @chart-update.window="initChart()">

 <!-- Header -->
 <div class="flex flex-col gap-5 mb-6 sm:flex-row sm:items-center sm:justify-between">
 <div class="flex flex-1 items-center justify-between space-x-2 sm:flex-initial">
 <h2 class="text-sm-plus font-medium tracking-wide text-zinc-800 dark:text-dark-100">
 Crescimento
 </h2>
 </div>

 <!-- Period Selector -->
 <div class="inline-flex items-center gap-0.5 bg-zinc-100 p-0.5 dark:bg-zinc-900">
 <button wire:click="$set('period', 'monthly')"
 class="px-3 py-2 font-medium text-theme-sm hover:text-zinc-900 hover:shadow-theme-xs dark:hover:bg-zinc-800 dark:hover:text-white {{ $period === 'monthly' ? 'shadow-theme-xs text-zinc-900 dark:text-white bg-white dark:bg-zinc-800' : 'text-zinc-500 dark:text-zinc-400' }}">
 Mensal
 </button>
 <button wire:click="$set('period', 'quarterly')"
 class="px-3 py-2 font-medium text-theme-sm hover:text-zinc-900 hover:shadow-theme-xs dark:hover:text-white {{ $period === 'quarterly' ? 'shadow-theme-xs text-zinc-900 dark:text-white bg-white dark:bg-zinc-800' : 'text-zinc-500 dark:text-zinc-400' }}">
 Trimestral
 </button>
 <button wire:click="$set('period', 'yearly')"
 class="px-3 py-2 font-medium text-theme-sm hover:text-zinc-900 hover:shadow-theme-xs dark:hover:text-white {{ $period === 'yearly' ? 'shadow-theme-xs text-zinc-900 dark:text-white bg-white dark:bg-zinc-800' : 'text-zinc-500 dark:text-zinc-400' }}">
 Anual
 </button>
 </div>
 </div>

 <!-- Stats Display -->
 <div class="flex gap-4 sm:gap-9">
 <!-- Users Stats -->
 <div class="flex items-start gap-2">
 <div>
 <h4 class="mb-0.5 text-base font-bold text-zinc-800 dark:text-white/90 sm:text-theme-xl">
 {{ number_format($currentPeriodUsers, 0, ',', '.') }}
 </h4>
 <span class="text-zinc-500 text-theme-xs dark:text-zinc-400">
 Total Usuários
 ({{ $period === 'monthly' ? 'Mês' : ($period === 'quarterly' ? 'Trimestre' : 'Ano') }})
 </span>
 </div>
 <span
 class="mt-1.5 flex items-center gap-1 {{ $usersGrowthPercentage >= 0 ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500' }} px-2 py-0.5 text-theme-xs font-medium">
 {{ $usersGrowthPercentage >= 0 ? '+' : '' }}{{ number_format($usersGrowthPercentage, 1) }}%
 </span>
 </div>

 <!-- Subscribers Stats -->
 <div class="flex items-start gap-2">
 <div>
 <h4 class="mb-0.5 text-base font-bold text-zinc-800 dark:text-white/90 sm:text-theme-xl">
 {{ number_format($currentPeriodSubscribers, 0, ',', '.') }}
 </h4>
 <span class="text-zinc-500 text-theme-xs dark:text-zinc-400">
 Total Assinantes
 ({{ $period === 'monthly' ? 'Mês' : ($period === 'quarterly' ? 'Trimestre' : 'Ano') }})
 </span>
 </div>
 <span
 class="mt-1.5 flex items-center gap-1 {{ $subscribersGrowthPercentage >= 0 ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/15 dark:text-cyan-500' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500' }} px-2 py-0.5 text-theme-xs font-medium">
 {{ $subscribersGrowthPercentage >= 0 ? '+' : '' }}{{ number_format($subscribersGrowthPercentage, 1) }}%
 </span>
 </div>
 </div>

 <!-- Chart -->
 <div class="max-w-full overflow-x-auto custom-scrollbar mt-6">
 <div id="userGrowthChart" class="-ml-4 min-w-[650px] pl-2 xl:min-w-full" style="min-height: 265px;"></div>
 </div>
</div>