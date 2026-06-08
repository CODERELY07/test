<x-modal-2 xShowName="openDeleteModal" header="Confirm Ticket Deletion">
    <div class="p-6 pt-0 text-center">
        <svg class="w-20 h-20 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>

        <h3 class="text-lg font-normal text-gray-500 mt-5 mb-1">
            Are you sure you want to delete this ticket?
        </h3>

        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-6">
            Ticket: <span x-text="activeRepair.ticket_number"></span> (<span x-text="activeRepair.name"></span>)
        </p>

        <div class="flex justify-center gap-2">
            <form action="{{ route('repairs.destroy') }}" method="POST">
                @csrf
                @method('DELETE')

                <input type="hidden" name="id" :value="activeRepair.id">

                <button type="submit" class="text-white bg-red-600 hover:bg-red-800 font-medium rounded-lg text-sm px-4 py-2.5">
                    Yes, I'm sure
                </button>
            </form>
            <button type="button"
                    @click="openDeleteModal = false"
                    class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 font-medium inline-flex items-center rounded-lg text-sm px-4 py-2.5 text-center">
                No, cancel
            </button>
        </div>
    </div>
</x-modal-2>
