<x-app-layout>
    <div class="py-8 bg-gray-50/50 dark:bg-gray-950 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">Welcome back, {{ Auth::user()->name }}</h1>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Here is a real-time summary overview of your workshop repair metrics today.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/60 shadow-sm transition">
                        <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Export Data
                    </button>
                    <button class="inline-flex items-center gap-2 px-4 py-2 text-xs font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-500 shadow-sm transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        New Ticket
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800/60 rounded-xl p-5 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Ongoing Repairs</span>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">14</h3>
                    </div>
                    <div class="p-2.5 rounded-lg bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.83-5.83m0 0a2.953 2.953 0 01-3.713-3.713L17.25 3.75l-3.375 3.375m0 0l-1.326-1.326m-7.22 10.03a11.112 11.112 0 011.666-6.663V6.75l6.663-1.666a11.111 11.111 0 016.663 1.666v1.666a11.11 11.11 0 01-1.666 6.663l-6.663 1.666a11.112 11.112 0 01-6.663-1.666v-1.666z"/></svg>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800/60 rounded-xl p-5 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pending Triages</span>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">6</h3>
                    </div>
                    <div class="p-2.5 rounded-lg bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800/60 rounded-xl p-5 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Completed Today</span>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">28</h3>
                    </div>
                    <div class="p-2.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800/60 rounded-xl p-5 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Daily Estimates</span>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">$1,420</h3>
                    </div>
                    <div class="p-2.5 rounded-lg bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.251.251a3.75 3.75 0 005.298 0L14.75 15.5a3.75 3.75 0 00-5.298 0L9 15.182M12 6a3.75 3.75 0 100 7.5h.5"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800/60 p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100 dark:border-gray-800/60">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100 tracking-tight">Active Operations Pipeline</h2>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Live operational overview listing active repair actions currently on-site.</p>
                    </div>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="relative flex-1 sm:flex-initial">
                            <input type="text" placeholder="Search ticket, customer..." class="w-full sm:w-64 rounded-lg border border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-950 text-xs py-2 px-3 pl-8 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white dark:focus:bg-gray-950 transition">
                            <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.604 10.604z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800/60 text-left">
                        <thead>
                            <tr class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                <th scope="col" class="py-4 pr-4">Ticket</th>
                                <th scope="col" class="px-4 py-4">Customer</th>
                                <th scope="col" class="px-4 py-4">Device Model</th>
                                <th scope="col" class="px-4 py-4">Category</th>
                                <th scope="col" class="px-4 py-4">Operational Status</th>
                                <th scope="col" class="px-4 py-4 text-right">Est. Valuation</th>
                                <th scope="col" class="py-4 pl-4 w-12"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800/30 text-xs text-gray-600 dark:text-gray-400">
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition duration-150">
                                <td class="py-4 pr-4 font-mono font-medium text-gray-900 dark:text-gray-100">#2026-001</td>
                                <td class="px-4 py-4 text-gray-900 dark:text-gray-100 font-medium">John Doe</td>
                                <td class="px-4 py-4 text-gray-500 dark:text-gray-400">iPhone 15 Pro Max</td>
                                <td class="px-4 py-4 opacity-60">Smartphone</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 font-medium text-amber-700 dark:text-amber-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Pending
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right font-medium text-gray-900 dark:text-gray-100">$150.00</td>
                                <td class="py-4 pl-4 text-right">
                                    <button class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-medium">View</button>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition duration-150">
                                <td class="py-4 pr-4 font-mono font-medium text-gray-900 dark:text-gray-100">#2026-002</td>
                                <td class="px-4 py-4 text-gray-900 dark:text-gray-100 font-medium">Jane Smith</td>
                                <td class="px-4 py-4 text-gray-500 dark:text-gray-400">MacBook Pro 14"</td>
                                <td class="px-4 py-4 opacity-60">Laptop</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 font-medium text-blue-700 dark:text-blue-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                        Ongoing
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right font-medium text-gray-900 dark:text-gray-100">$450.00</td>
                                <td class="py-4 pl-4 text-right">
                                    <button class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-medium">View</button>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition duration-150">
                                <td class="py-4 pr-4 font-mono font-medium text-gray-900 dark:text-gray-100">#2026-003</td>
                                <td class="px-4 py-4 text-gray-900 dark:text-gray-100 font-medium">Michael Chang</td>
                                <td class="px-4 py-4 text-gray-500 dark:text-gray-400">PlayStation 5 Slim</td>
                                <td class="px-4 py-4 opacity-60">Console</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 font-medium text-emerald-700 dark:text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Completed
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right font-medium text-gray-900 dark:text-gray-100">$120.00</td>
                                <td class="py-4 pl-4 text-right">
                                    <button class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-medium">View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pt-5 flex items-center justify-between border-t border-gray-50 dark:border-gray-800/40 mt-2">
                    <p class="text-[11px] text-gray-400 dark:text-gray-500">Showing last 3 active tracking entries without active truncation limits.</p>
                    <a href="#" class="text-[11px] font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">View All Tickets →</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
