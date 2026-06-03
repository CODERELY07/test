<x-modal-2 xShowName="openViewModal">
    <x-slot:uniqueHeader>
        <div>
            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400" x-text="activeRepair.ticket_number"></span>
            <h3 class="text-base font-bold text-gray-900 tracking-tight mt-0.5">Ticket Details</h3>
        </div>
    </x-slot:uniqueHeader>
    
    <div class="mt-4 space-y-4 text-xs">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="block text-gray-400 font-medium">Customer Name</span>
                <span class="block mt-1 font-bold text-gray-900 text-sm" x-text="activeRepair.name"></span>
            </div>
            <div>
                <span class="block text-gray-400 font-medium">Ticket Status</span>
                <div class="mt-1.5">
                    <span class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] tracking-wider px-2.5 py-1 rounded-full"
                            :class="{
                                'bg-amber-50 text-amber-700 border border-amber-200': activeRepair.status === 'pending',
                                'bg-blue-50 text-blue-700 border border-blue-200': activeRepair.status === 'ongoing',
                                'bg-emerald-50 text-emerald-700 border border-emerald-200': activeRepair.status === 'completed'
                            }">
                        <span class="h-1 w-1 rounded-full"
                                :class="{
                                    'bg-amber-500': activeRepair.status === 'pending',
                                    'bg-blue-500 animate-pulse': activeRepair.status === 'ongoing',
                                    'bg-emerald-500': activeRepair.status === 'completed'
                                }"></span>
                        <span x-text="activeRepair.status"></span>
                    </span>
                </div>
            </div>
        </div>

        <hr class="border-gray-100" />

        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="block text-gray-400 font-medium">Device Model</span>
                <span class="block mt-1 font-medium text-gray-800" x-text="activeRepair.model"></span>
            </div>
            <div>
                <span class="block text-gray-400 font-medium">Device Category</span>
                <span class="block mt-1 font-medium text-gray-800" x-text="activeRepair.category"></span>
            </div>
        </div>

        <hr class="border-gray-100" />

        <div>
            <span class="block text-gray-400 font-medium">Estimated Repair Cost</span>
            <span class="block mt-1 text-sm font-mono font-bold text-gray-900" x-text="'₱' + parseFloat(activeRepair.estimated_cost).toFixed(2)"></span>
        </div>

        <hr class="border-gray-100" />

        <div>
            <span class="block text-gray-400 font-medium">Problem Description</span>
            <p class="mt-1.5 p-3 rounded-xl bg-gray-50 text-gray-600 leading-relaxed border border-gray-200/60 whitespace-pre-wrap font-sans text-[11px]" x-text="activeRepair.description || 'No description provided.'"></p>
        </div>
    </div>

    <div class="pt-3 flex items-center justify-end border-t border-gray-100 mt-6">
        <button type="button" @click="openViewModal = false" class="px-4 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 transition text-xs font-semibold rounded-xl shadow-sm">
            Close Details
        </button>
    </div>
</x-modal-2>