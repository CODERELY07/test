<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8"
         x-data="{
            searched: false,
            ticketNumber: '',
            loading: false,
            repair: null,

            async searchTicket() {
                if (!this.ticketNumber.trim()) return;

                this.loading = true;
                this.searched = false;

                try {
                    // URL encode to safely handle '#' symbols if the user types them
                    let response = await fetch('/track-repair/' + encodeURIComponent(this.ticketNumber));
                    this.repair = await response.json();
                    this.searched = true;
                } catch (error) {
                    console.error('Tracking fetch failed:', error);
                    this.repair = { found: false };
                    this.searched = true;
                } finally {
                    this.loading = false;
                }
            }
         }">

        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Track Your Repair</h1>
                <p class="mt-2 text-sm text-gray-500 font-medium">Enter your tracking identifier or ticket number to check the real-time status of your device.</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200/60 p-6 shadow-sm mb-8">
                <form @submit.prevent="searchTicket()" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.604 10.604z" />
                            </svg>
                        </div>
                        <input type="text"
                               x-model="ticketNumber"
                               required
                               placeholder="e.g., #2026-002"
                               class="block w-full rounded-xl border border-gray-200 bg-gray-50/30 py-3 pl-10 pr-3 text-sm font-medium text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    </div>
                    <button type="submit"
                            :disabled="loading"
                            class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-bold text-white hover:bg-gray-800 transition active:scale-[0.99] shadow-sm disabled:opacity-50 inline-flex items-center justify-center gap-2">
                        <span x-show="!loading">Search Ticket</span>
                        <span x-show="loading" style="display: none;" class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                    </button>
                </form>
            </div>

            <div x-show="searched" x-transition x-cloak class="space-y-6">

                <template x-if="repair && repair.found">
                    <div class="space-y-6">

                        <div class="bg-white rounded-2xl border border-gray-200/60 p-8 shadow-sm">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-4 border-b border-gray-100">
                                <div>
                                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400 block">Current Status</span>

                                    <h2 x-show="repair.status === 'completed'" class="text-base font-black text-emerald-600 flex items-center gap-2 mt-1">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Ready for Pick Up
                                    </h2>
                                    <h2 x-show="repair.status === 'ongoing'" class="text-base font-black text-blue-600 flex items-center gap-2 mt-1">
                                        <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                        Repair Ongoing
                                    </h2>
                                    <h2 x-show="repair.status !== 'completed' && repair.status !== 'ongoing'" class="text-base font-black text-amber-600 flex items-center gap-2 mt-1">
                                        <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                        Ticket Created / Pending
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
                                     :style="'width: ' + (repair.status === 'completed' ? '100%' : (repair.status === 'ongoing' ? '50%' : '0%')) + ';'">
                                </div>

                                <div class="relative z-10 flex flex-col items-center">
                                    <div class="h-7 w-7 rounded-full bg-gray-900 text-white flex items-center justify-center border-4 border-white shadow-sm ring-4 ring-gray-100/30">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </div>
                                    <span class="absolute top-9 whitespace-nowrap text-[11px] font-bold text-gray-900">Ticket Created</span>
                                </div>

                                <div class="relative z-10 flex flex-col items-center">
                                    <div :class="repair.status === 'ongoing' || repair.status === 'completed' ? 'bg-gray-900 text-white border-white ring-gray-100/30' : 'bg-white text-gray-300 border-gray-100'"
                                         class="h-7 w-7 rounded-full flex items-center justify-center border-4 shadow-sm transition-all duration-300">
                                        <template x-if="repair.status === 'completed'">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </template>
                                        <template x-if="repair.status === 'ongoing'">
                                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                        </template>
                                    </div>
                                    <span class="absolute top-9 whitespace-nowrap text-[11px]"
                                          :class="repair.status === 'ongoing' || repair.status === 'completed' ? 'font-bold text-gray-900' : 'font-medium text-gray-400'">In Progress</span>
                                </div>

                                <div class="relative z-10 flex flex-col items-center">
                                    <div :class="repair.status === 'completed' ? 'bg-emerald-600 text-white border-white ring-emerald-100' : 'bg-white text-gray-300 border-gray-100'"
                                         class="h-7 w-7 rounded-full flex items-center justify-center border-4 shadow-sm transition-all duration-300">
                                        <template x-if="repair.status === 'completed'">
                                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                        </template>
                                    </div>
                                    <span class="absolute top-9 whitespace-nowrap text-[11px]"
                                          :class="repair.status === 'completed' ? 'font-bold text-emerald-600' : 'font-medium text-gray-400'">Ready for Pick Up</span>
                                </div>
                            </div>
                            <div class="h-8"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="bg-white rounded-2xl border border-gray-200/60 p-6 shadow-sm flex flex-col justify-between">
                                <div>
                                    <h3 class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400 mb-4">Device Information</h3>
                                    <dl class="space-y-3.5 text-xs">
                                        <div class="flex justify-between items-center">
                                            <dt class="font-medium text-gray-400">Device Model</dt>
                                            <dd class="font-bold text-gray-900" x-text="repair.model"></dd>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <dt class="font-medium text-gray-400">Category</dt>
                                            <dd class="font-mono text-[11px] font-bold text-gray-500 uppercase bg-gray-50 border border-gray-100 px-2 py-0.5 rounded-md" x-text="repair.category"></dd>
                                        </div>
                                        <div class="pt-3.5 border-t border-gray-100">
                                            <dt class="font-medium text-gray-400 mb-1.5">Reported Issue</dt>
                                            <dd class="font-medium text-gray-600 leading-relaxed bg-gray-50/50 p-3 rounded-xl border border-gray-100/80" x-text="repair.description"></dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-gray-200/60 p-6 shadow-sm flex flex-col justify-between">
                                <div>
                                    <h3 class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400 mb-4">Financial Breakdown</h3>
                                    <dl class="space-y-3.5 text-xs">
                                        <div class="flex justify-between items-center">
                                            <dt class="font-medium text-gray-400">Estimated Cost</dt>
                                            <dd class="font-mono font-bold text-gray-900" x-text="'₱' + repair.estimated_cost"></dd>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <dt class="font-medium text-gray-400">Tax & Surcharges</dt>
                                            <dd class="font-medium text-emerald-600 bg-emerald-500/5 px-2 py-0.5 rounded-md font-mono text-[10px] tracking-wide font-bold uppercase">Included</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-4">
                                    <span class="text-xs font-bold text-gray-900">Amount Due</span>
                                    <span class="text-xl font-mono font-black text-gray-900" x-text="'₱' + repair.estimated_cost"></span>
                                </div>
                            </div>

                        </div>

                        <p class="text-center text-[11px] text-gray-400 font-medium pt-4">
                            Have questions about your calculation matrix? Please contact support citing ticket ID reference above.
                        </p>
                    </div>
                </template>

                <template x-if="repair && !repair.found">
                    <div class="bg-white rounded-2xl border border-gray-200/60 p-12 text-center shadow-sm">
                        <div class="inline-flex p-3 rounded-xl bg-amber-500/5 text-amber-500 mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        </div>
                        <h3 class="text-sm font-black text-gray-900 tracking-tight">No Record Discovered</h3>
                        <p class="text-xs text-gray-400 font-medium mt-1 max-w-sm mx-auto">We couldn't find any repair sequence logs matching reference identifier <span class="font-mono font-bold text-gray-600" x-text="'&quot;' + ticketNumber + '&quot;'"></span>.</p>
                    </div>
                </template>

            </div>
        </div>
    </div>
</x-guest-layout>
