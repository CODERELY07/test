<x-app-layout>
    <div class="p-6 bg-white mt-10 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 tracking-tight">Repairs</h1>
                <p class="mt-1 text-xs text-gray-500">Overview of all active and resolved maintenance tickets.</p>
            </div>
            <div class="flex items-center gap-3">
                <input type="text" placeholder="Search..." class="w-60 rounded-lg border-gray-200 bg-gray-50/50 text-xs py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 focus:bg-white transition">
                <button class="rounded-lg bg-gray-900 px-4 py-2 text-xs font-medium text-white hover:bg-gray-800 transition shadow-sm">
                    New Ticket
                </button>
            </div>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-left">
                <thead>
                    <tr class="text-[11px] font-medium uppercase tracking-wider text-gray-400">
                        <th scope="col" class="py-4 pr-4 font-semibold">Ticket</th>
                        <th scope="col" class="px-4 py-4 font-semibold">Customer</th>
                        <th scope="col" class="px-4 py-4 font-semibold">Device</th>
                        <th scope="col" class="px-4 py-4 font-semibold">Category</th>
                        <th scope="col" class="px-4 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-4 py-4 font-semibold text-right">Est. Cost</th>
                        <th scope="col" class="py-4 pl-4 w-12"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-xs text-gray-600">
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-4 pr-4 font-medium text-gray-900">#2026-001</td>
                        <td class="px-4 py-4 text-gray-900 font-medium">John Doe</td>
                        <td class="px-4 py-4 text-gray-500">iPhone 15 Pro Max</td>
                        <td class="px-4 py-4 text-gray-400">Smartphone</td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 font-medium text-amber-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                Pending
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right font-medium text-gray-900">$150.00</td>
                        <td class="py-4 pl-4 text-right">
                            <button class="text-gray-400 hover:text-gray-900 transition font-medium">View</button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-4 pr-4 font-medium text-gray-900">#2026-002</td>
                        <td class="px-4 py-4 text-gray-900 font-medium">Jane Smith</td>
                        <td class="px-4 py-4 text-gray-500">MacBook Pro 14"</td>
                        <td class="px-4 py-4 text-gray-400">Laptop</td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 font-medium text-blue-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                Ongoing
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right font-medium text-gray-900">$450.00</td>
                        <td class="py-4 pl-4 text-right">
                            <button class="text-gray-400 hover:text-gray-900 transition font-medium">View</button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-4 pr-4 font-medium text-gray-900">#2026-003</td>
                        <td class="px-4 py-4 text-gray-900 font-medium">Michael Chang</td>
                        <td class="px-4 py-4 text-gray-500">PlayStation 5 Slim</td>
                        <td class="px-4 py-4 text-gray-400">Console</td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 font-medium text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Completed
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right font-medium text-gray-900">$120.00</td>
                        <td class="py-4 pl-4 text-right">
                            <button class="text-gray-400 hover:text-gray-900 transition font-medium">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
