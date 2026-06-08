<x-app-layout>
    <div x-data="{
        openCreateModal: false,
        openViewModal: false,
        openEditModal: false,
        openDeleteModal: false,
        activeRepair: {}
    }" class="py-8 bg-gray-50/50 dark:bg-gray-950 min-h-screen transition-colors duration-300">

        <div class="p-6 bg-white dark:bg-gray-900 mt-10 max-w-7xl mx-auto rounded-2xl border border-gray-100 dark:border-gray-800/60 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100 dark:border-gray-800/60">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100 tracking-tight">Repairs</h1>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Overview of all active and resolved maintenance tickets.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ url()->current() }}">
                        <input type="text" placeholder="Search..." value="{{request('searchName')}}" class="w-60 rounded-lg border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-950 text-xs py-2 px-3 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition" name="searchName" id="searchName">
                        <input type="submit" class="cursor-pointer rounded-lg bg-slate-600 px-4 py-2 text-xs font-medium text-white hover:bg-slate-500 transition shadow-sm" value="Search">
                    </form>
                    @if(request('searchName'))
                        <a href="{{ url()->current() }}" class="border-l border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors duration-150 flex items-center justify-center h-full">
                            Clear
                        </a>
                    @endif
                    <button @click="openCreateModal = true" class="rounded-lg bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-500 transition shadow-sm">
                        New Ticket
                    </button>
                </div>
            </div>

            @include('admin.partials.repairs-table')
        </div>

        @include('admin.partials.repairs-delete')
        @include('admin.partials.repairs-add')
        @include('admin.partials.repairs-view')
        @include('admin.partials.repairs-edit')

    </div>
</x-app-layout>
