<div x-data="{ activeTab: 0 }">
 
 <div class="overflow-hidden p-1">
 <ul class="flex items-center gap-2 text-sm font-medium" role="tablist">
 {{ $tabs }} 
 </ul>
 </div>
 
 <div class="py-4">
 {{ $content }} 
 </div>

</div>