<div class="bg-white rounded-2xl border border-gray-200/60 p-8 shadow-sm">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-4 border-b border-gray-100">
        <div>
            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400 block">Current Status</span>
            <h2 x-show="repair.status === 'completed'" class="text-base font-black text-emerald-600 flex items-center gap-2 mt-1">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Ready for Pick Up
            </h2>
            <h2 x-show="repair.status === 'ongoing'" class="text-base font-black text-blue-600 flex items-center gap-2 mt-1">
                <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span> Repair Ongoing
            </h2>
            <h2 x-show="repair.status !== 'completed' && repair.status !== 'ongoing'" class="text-base font-black text-amber-600 flex items-center gap-2 mt-1">
                <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span> Ticket Created / Pending
            </h2>
        </div>
        <div class="sm:text-right">
            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400 block">Tracking Reference</span>
            <p class="text-sm font-mono font-bold text-gray-900 mt-1" x-text="repair.ticket_number"></p>
        </div>
    </div>

    <div class="relative flex items-center justify-between w-full mt-12 px-4 mb-6">
        <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-0.5 bg-gray-100 z-0"></div>
        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-gray-900 z-0 transition-all duration-500"
             :style="'width: ' + (repair.status === 'completed' ? '100%' : (repair.status === 'ongoing' ? '50%' : '0%')) + ';'"></div>

        <div class="relative z-10 flex flex-col items-center">
            <div class="h-7 w-7 rounded-full bg-gray-900 text-white flex items-center justify-center border-4 border-white shadow-sm ring-4 ring-gray-100/30">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            </div>
            <span class="absolute top-9 whitespace-nowrap text-[11px] font-bold text-gray-900">Ticket Created</span>
        </div>

        <div class="relative z-10 flex flex-col items-center">
            <div :class="repair.status === 'ongoing' || repair.status === 'completed' ? 'bg-gray-900 text-white border-white ring-gray-100/30' : 'bg-white text-gray-300 border-gray-100'" class="h-7 w-7 rounded-full flex items-center justify-center border-4 shadow-sm transition-all duration-300">
                <svg x-show="repair.status === 'completed'" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                <span x-show="repair.status === 'ongoing'" class="h-1.5 w-1.5 rounded-full bg-white"></span>
            </div>
            <span class="absolute top-9 whitespace-nowrap text-[11px]" :class="repair.status === 'ongoing' || repair.status === 'completed' ? 'font-bold text-gray-900' : 'font-medium text-gray-400'">In Progress</span>
        </div>

        <div class="relative z-10 flex flex-col items-center">
            <div :class="repair.status === 'completed' ? 'bg-emerald-600 text-white border-white ring-emerald-100' : 'bg-white text-gray-300 border-gray-100'" class="h-7 w-7 rounded-full flex items-center justify-center border-4 shadow-sm transition-all duration-300">
                <span x-show="repair.status === 'completed'" class="h-1.5 w-1.5 rounded-full bg-white"></span>
            </div>
            <span class="absolute top-9 whitespace-nowrap text-[11px]" :class="repair.status === 'completed' ? 'font-bold text-emerald-600' : 'font-medium text-gray-400'">Ready for Pick Up</span>
        </div>
    </div>
    <div class="h-8"></div>
</div>
