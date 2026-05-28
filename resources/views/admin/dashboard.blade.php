<x-app-layout>
    <div class="py-10 bg-gray-50/60 dark:bg-gray-950 min-h-screen transition-colors duration-300 selection:bg-indigo-500/10 selection:text-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 pb-2">
                <div class="space-y-1">
                    <h1 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white sm:text-3xl">
                        Welcome back, {{ Auth::user()->name }}
                    </h1>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">
                        Here is a real-time summary overview of your workshop repair metrics today.
                    </p>
                </div>
                <div class="flex items-center gap-2.5 w-full sm:w-auto">
                    <button class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold rounded-xl text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-900 border border-gray-200/70 dark:border-gray-800/80 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white transition-all active:scale-[0.98]">
                        <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Export
                    </button>
                    <button class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4.5 py-2.5 text-xs font-bold rounded-xl text-white bg-gray-900 dark:bg-indigo-600 hover:bg-gray-800 dark:hover:bg-indigo-500 transition-all active:scale-[0.98] shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        New Ticket
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="relative overflow-hidden bg-white dark:bg-gray-900 border border-gray-200/60 dark:border-gray-800/60 rounded-2xl p-6 transition-all hover:border-gray-300 dark:hover:border-gray-700">
                    <div class="flex items-start justify-between">
                        <div class="space-y-3">
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block font-mono">Ongoing Work</span>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight">{{ $ongoingCount }}</h3>
                        </div>
                        <div class="p-2 rounded-xl bg-blue-500/5 text-blue-500 dark:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.83-5.83m0 0a2.953 2.953 0 01-3.713-3.713L17.25 3.75l-3.375 3.375m0 0l-1.326-1.326m-7.22 10.03a11.112 11.112 0 011.666-6.663V6.75l6.663-1.666a11.111 11.111 0 016.663 1.666v1.666a11.11 11.11 0 01-1.666 6.663l-6.663 1.666a11.112 11.112 0 01-6.663-1.666v-1.666z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-white dark:bg-gray-900 border border-gray-200/60 dark:border-gray-800/60 rounded-2xl p-6 transition-all hover:border-gray-300 dark:hover:border-gray-700">
                    <div class="flex items-start justify-between">
                        <div class="space-y-3">
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block font-mono">In Queue</span>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight">{{ $pendingCount }}</h3>
                        </div>
                        <div class="p-2 rounded-xl bg-amber-500/5 text-amber-500 dark:text-amber-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-white dark:bg-gray-900 border border-gray-200/60 dark:border-gray-800/60 rounded-2xl p-6 transition-all hover:border-gray-300 dark:hover:border-gray-700">
                    <div class="flex items-start justify-between">
                        <div class="space-y-3">
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block font-mono">Done Today</span>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight">{{ $completedTodayCount }}</h3>
                        </div>
                        <div class="p-2 rounded-xl bg-emerald-500/5 text-emerald-500 dark:text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-indigo-600 dark:bg-indigo-600 rounded-2xl p-6 shadow-md shadow-indigo-500/10">
                    <div class="absolute -right-6 -bottom-6 text-indigo-700/30 dark:text-indigo-500/20 pointer-events-none">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 6v12m-3-2.818l.251.251a3.75 3.75 0 005.298 0L14.75 15.5a3.75 3.75 0 00-5.298 0L9 15.182M12 6a3.75 3.75 0 100 7.5h.5"/></svg>
                    </div>
                    <div class="relative z-10 flex flex-col justify-between h-full space-y-3">
                        <span class="text-[10px] font-bold text-indigo-200 uppercase tracking-widest block font-mono">Gross Estimates</span>
                        <h3 class="text-3xl font-black text-white tracking-tight">₱{{ number_format($dailyEstimatesSum, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-black text-gray-900 dark:text-white tracking-tight">Active Repair Stream</h2>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">Click any workspace dashboard record card parameters configuration panel directly to edit.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($repairs as $repair)
                    @php
                        $statusRaw = Str::lower($repair->status->value ?? $repair->status);
                    @endphp

                    <div type="button"
                         @click="$dispatch('open-edit-repair-modal', {
                             id: '{{ $repair->id }}',
                             ticket_number: '{{ $repair->ticket_number }}',
                             name: '{{ addslashes($repair->name) }}',
                             model: '{{ addslashes($repair->model) }}',
                             category: '{{ addslashes($repair->category) }}',
                             estimated_cost: '{{ $repair->estimated_cost }}',
                             description: '{{ addslashes($repair->description) }}',
                             status: '{{ $statusRaw }}'
                         })"
                         class="group relative text-left bg-white dark:bg-gray-900 border border-gray-200/60 dark:border-gray-800/60 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-gray-300 dark:hover:border-gray-700 transition-all duration-200 cursor-pointer flex flex-col justify-between gap-4">

                        <div class="flex items-start justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] font-mono font-bold tracking-tight text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-950 px-2 py-0.5 rounded-md border border-gray-100 dark:border-gray-900">
                                        {{ $repair->ticket_number }}
                                    </span>

                                    @if($statusRaw === 'completed')
                                        <span class="inline-flex items-center text-[9px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 font-mono bg-emerald-500/5 px-2 py-0.5 rounded-md">Completed</span>
                                    @elseif($statusRaw === 'ongoing')
                                        <span class="inline-flex items-center text-[9px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 font-mono bg-blue-500/5 px-2 py-0.5 rounded-md">Ongoing</span>
                                    @else
                                        <span class="inline-flex items-center text-[9px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400 font-mono bg-amber-500/5 px-2 py-0.5 rounded-md">Pending</span>
                                    @endif
                                </div>
                                <h4 class="text-sm font-black text-gray-900 dark:text-white tracking-tight pt-1">
                                    {{ $repair->name }}
                                </h4>
                            </div>

                            <div class="text-right">
                                <span class="text-sm font-mono font-bold text-gray-900 dark:text-white">
                                    ₱{{ number_format($repair->estimated_cost, 2) }}
                                </span>
                                <span class="block text-[9px] font-bold text-gray-400 dark:text-gray-500 font-mono uppercase tracking-wider mt-0.5">Est. Cost</span>
                            </div>
                        </div>

                        @if($repair->description)
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium line-clamp-2 bg-gray-50/50 dark:bg-gray-950/40 p-3 rounded-xl border border-gray-100 dark:border-gray-900/50">
                                {{ $repair->description }}
                            </p>
                        @endif

                        <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800/80 pt-3 text-[10px] font-mono font-bold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            <div class="flex items-center gap-1.5">
                                <span class="text-gray-700 dark:text-gray-300 font-sans normal-case font-semibold">{{ $repair->model }}</span>
                                <span class="opacity-30">•</span>
                                <span>{{ $repair->category }}</span>
                            </div>
                            <div class="inline-flex items-center gap-1 text-indigo-600 dark:text-indigo-400 opacity-0 group-hover:opacity-100 transition-all font-sans font-semibold normal-case translate-x-2 group-hover:translate-x-0">
                                Open Editor
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 text-center py-16 bg-white dark:bg-gray-900 border border-gray-200/60 dark:border-gray-800/60 rounded-2xl">
                        <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 font-mono uppercase tracking-widest block mb-1">Zero Records Found</span>
                        <p class="text-xs text-gray-400 dark:text-gray-500 font-medium">No active repair ticket data records discovered in workspace.</p>
                    </div>
                @endforelse
            </div>

            @if($repairs->hasPages())
                <div class="pt-2">
                    {{ $repairs->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
