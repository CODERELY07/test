<div class="bg-white rounded-2xl border border-gray-200/60 p-6 shadow-sm mb-8">
    <form @submit.prevent="searchTicket()" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.604 10.604z" />
                </svg>
            </div>
            <input type="text" x-model="ticketNumber" required placeholder="e.g., #2026-002"
                   class="block w-full rounded-xl border border-gray-200 bg-gray-50/30 py-3 pl-10 pr-3 text-sm font-medium text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
        </div>
        <button type="submit" :disabled="loading" class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-bold text-white hover:bg-gray-800 transition active:scale-[0.99] shadow-sm disabled:opacity-50 inline-flex items-center justify-center gap-2">
            <span x-show="!loading">Search Ticket</span>
            <span x-show="loading" style="display: none;" class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
        </button>
    </form>
</div>
