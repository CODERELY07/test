<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8"
         x-data="{ searched: true, ticketNumber: '#2026-002' }">

        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Track Your Repair</h1>
                <p class="mt-2 text-sm text-gray-500">Enter your tracking identifier or ticket number to check the real-time status of your device.</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm mb-8">
                <form @submit.prevent="searched = true" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.604 10.604z" />
                            </svg>
                        </div>
                        <input type="text"
                               x-model="ticketNumber"
                               required
                               placeholder="e.g., #2026-002"
                               class="block w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-3 text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-900 focus:border-gray-900 transition">
                    </div>
                    <button type="submit" class="rounded-lg bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-gray-800 transition shadow-sm">
                        Search Ticket
                    </button>
                </form>
            </div>

            <div x-show="searched" x-transition class="space-y-6" x-cloak>

                <div class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Current Status</span>
                            <h2 class="text-lg font-medium text-blue-700 flex items-center gap-1.5 mt-0.5">
                                <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                Repair Ongoing
                            </h2>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Ticket Number</span>
                            <p class="text-sm font-medium text-gray-900 mt-0.5" x-text="ticketNumber">#2026-002</p>
                        </div>
                    </div>

                    <div class="relative flex items-center justify-between w-full mt-12 px-4">
                        <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-0.5 bg-gray-100 z-0"></div>
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-gray-900 z-0" style="width: 50%;"></div>

                        <div class="relative z-10 flex flex-col items-center">
                            <div class="h-7 w-7 rounded-full bg-gray-900 text-white flex items-center justify-center border-4 border-white shadow-sm">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <span class="absolute top-9 whitespace-nowrap text-xs font-medium text-gray-900">Ticket Created</span>
                        </div>

                        <div class="relative z-10 flex flex-col items-center">
                            <div class="h-7 w-7 rounded-full bg-white text-gray-900 flex items-center justify-center border-4 border-gray-900 shadow-sm ring-4 ring-gray-100">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-900"></span>
                            </div>
                            <span class="absolute top-9 whitespace-nowrap text-xs font-semibold text-gray-900">In Progress</span>
                        </div>

                        <div class="relative z-10 flex flex-col items-center">
                            <div class="h-7 w-7 rounded-full bg-white text-gray-300 flex items-center justify-center border-4 border-gray-100 shadow-sm"></div>
                            <span class="absolute top-9 whitespace-nowrap text-xs font-medium text-gray-400">Ready for Pick Up</span>
                        </div>
                    </div>
                    <div class="h-10"></div> </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Device Information</h3>
                        <dl class="space-y-3 text-xs">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Device Model</dt>
                                <dd class="font-medium text-gray-900">MacBook Pro 14" (M3)</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Category</dt>
                                <dd class="font-medium text-gray-400">Laptop</dd>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-gray-50">
                                <dt class="text-gray-500">Reported Issue</dt>
                                <dd class="font-medium text-gray-900 max-w-[200px] text-right truncate">Battery replacement and keyboard servicing.</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Financial Breakdown</h3>
                            <dl class="space-y-3 text-xs">
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Estimated Cost</dt>
                                    <dd class="font-medium text-gray-900">$450.00</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Tax & Fees</dt>
                                    <dd class="font-medium text-gray-500">Included</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-50 mt-3">
                            <span class="text-xs font-medium text-gray-900">Amount Due</span>
                            <span class="text-base font-semibold text-gray-900">$450.00</span>
                        </div>
                    </div>
                </div>

                <p class="text-center text-[11px] text-gray-400 pt-2">
                    Have questions about your calculation matrix? Please contact support citing ticket ID reference above.
                </p>

            </div>
        </div>
    </div>
</x-guest-layout>
