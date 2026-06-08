<div class="mt-4 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800/60 text-left">
        <thead>
            <tr class="text-[11px] font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">
                <th scope="col" class="py-4 pr-4 font-semibold">Ticket</th>
                <th scope="col" class="px-4 py-4 font-semibold">Customer</th>
                <th scope="col" class="px-4 py-4 font-semibold">Device</th>
                <th scope="col" class="px-4 py-4 font-semibold">Category</th>
                <th scope="col" class="px-4 py-4 font-semibold">Status</th>
                <th scope="col" class="px-4 py-4 font-semibold text-right">Est. Cost</th>
                <th scope="col" class="py-4 pl-4 w-24"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800/30 text-xs text-gray-600 dark:text-gray-400">
            @forelse ($repairs as $repair)
                @php

                    $statusString = $repair->status->value ?? $repair->status;

                    $statusColors = match(Str::lower($statusString)) {
                        'pending'   => ['text' => 'text-amber-700 dark:text-amber-400', 'dot' => 'bg-amber-500'],
                        'ongoing'   => ['text' => 'text-blue-700 dark:text-blue-400',     'dot' => 'bg-blue-500 animate-pulse'],
                        'completed' => ['text' => 'text-emerald-700 dark:text-emerald-400', 'dot' => 'bg-emerald-500'],
                        default     => ['text' => 'text-gray-700 dark:text-gray-400',    'dot' => 'bg-gray-500'],
                    };
                @endphp

                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition">
                    <td class="py-4 pr-4 font-medium text-gray-900 dark:text-gray-100">{{ $repair->ticket_number }}</td>
                    <td class="px-4 py-4 text-gray-900 dark:text-gray-100 font-medium">{{ $repair->name }}</td>
                    <td class="px-4 py-4 text-gray-500 dark:text-gray-400">{{ $repair->model }}</td>
                    <td class="px-4 py-4 text-gray-400 dark:text-gray-500">{{ $repair->category }}</td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center gap-1.5 font-medium {{ $statusColors['text'] }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $statusColors['dot'] }}"></span>
                            {{ ucwords($statusString) }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-right font-medium text-gray-900 dark:text-gray-100">₱{{ $repair->estimated_cost }}</td>
                    <td class="py-4 pl-4 text-right">
                        <div class="flex justify-end gap-3">
                                <button type="button"
                                    @click="activeRepair = @js([
                                        'id' => $repair->id,
                                        'ticket_number' => $repair->ticket_number,
                                        'name' => $repair->name,
                                        'model' => $repair->model,
                                        'category' => $repair->category,
                                        'estimated_cost' => $repair->estimated_cost,
                                        'description' => $repair->description,
                                        'status' => Str::lower($statusString),
                                        'downpayment' => $repair->downpayment,
                                    ]); openViewModal = true;"
                                    class="text-gray-500 hover:text-slate-400 dark:hover:text-white transition font-medium text-xs">
                                View
                            </button>
                            <button
                                type="button"
                                @click="$dispatch('open-edit-repair-modal', @js([
                                    'id' => $repair->id,
                                    'ticket_number' => $repair->ticket_number,
                                    'name' => $repair->name,
                                    'model' => $repair->model,
                                    'category' => $repair->category,
                                    'estimated_cost' => $repair->estimated_cost,
                                    'downpayment' => $repair->downpayment,
                                    'description' => $repair->description,
                                    'status' => strtolower($repair->status->value ?? $repair->status),
                                ]))"
                                class="text-gray-500 hover:text-slate-400 dark:hover:text-white transition font-medium text-xs">
                                Edit
                            </button>
                            <button type="button"
                                    @click="activeRepair = @js([
                                        'id' => $repair->id,
                                        'ticket_number' => $repair->ticket_number,
                                        'name' => $repair->name,
                                    ]); openDeleteModal = true;"
                                    class="text-gray-500 hover:text-slate-400 dark:hover:text-white transition font-medium text-xs">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-sm font-medium text-gray-400 dark:text-gray-500">
                        No Repairs Found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $repairs->links() }}
    </div>
</div>
