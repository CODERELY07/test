<div
    x-data="{
        openEditModal: false,
        form: null,

        init() {
            // Provide a clean fallback state during initial page load
            this.form = $form('patch', '/repairs/0', {
                id: '',
                ticket_number: '',
                name: '',
                model: '',
                category: '',
                estimated_cost: '',
                downpayment: '',
                description: '',
                status: 'pending'
            });
        },

        openModal(data) {
            // 1. Build and bind populated dataset immediately
            this.form = $form('patch', `/repairs/${data.id}`, {
                id: data.id,
                ticket_number: data.ticket_number ?? '',
                name: data.name ?? '',
                model: data.model ?? '',
                category: data.category ?? '',
                downpayment: data.downpayment ?? '',
                estimated_cost: Number(data.estimated_cost ?? 0),
                description: data.description ?? '',
                status: data.status ?? 'pending'
            });

            this.openEditModal = true;
        },

        submitUpdate() {
            console.log('Submitting patch request to ID:', this.form.id);

            this.form.submit()
                .then(() => {
                    this.openEditModal = false;
                    alert('Ticket successfully updated!');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Update Error Encountered:', error);
                });
        }
    }"
    @open-edit-repair-modal.window="openModal($event.detail)"
    x-show="openEditModal"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display:none;"
>
    <x-modal-2 xShowName="openEditModal">
        <x-slot:uniqueHeader>
            <div>
                <span
                    class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400"
                    x-text="form?.ticket_number ? 'Editing: ' + form.ticket_number : 'Loading Component Data...'">
                </span>

                <h3 class="text-base font-bold text-gray-900 mt-1">
                    Edit Ticket Details
                </h3>
            </div>
        </x-slot:uniqueHeader>

        <form @submit.prevent="submitUpdate()" class="mt-4 space-y-4 text-xs">
            @csrf

            <x-input-with-validation model="name" label="Customer Name" placeholder="Enter customer name" />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input-with-validation model="model" label="Device Model" placeholder="e.g., iPhone 13 Pro" />
                <x-input-with-validation model="category" label="Device Category" placeholder="e.g., Smartphone" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input-with-validation model="estimated_cost" type="number" label="Estimated Cost (₱)" placeholder="0.00" />
                 <x-input-with-validation model="downpayment" type="number"  placeholder="150.00" label="Downpayment (₱)"/>

            </div>
            <div>
                <label for="status" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Ticket Status</label>
                <select
                    id="status"
                    name="status"
                    x-model="form.status"
                    @change="form.validate?.('status')"
                    class="block mt-1.5 w-full rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-950 text-sm py-2.5 px-3.5 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition"
                >
                    <option value="pending">PENDING</option>
                    <option value="ongoing">ONGOING</option>
                    <option value="completed">COMPLETED</option>
                </select>
            </div>
            <x-input-with-validation model="description" label="Problem Description" placeholder="Describe the device fault..." />

            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100">
                <button
                    type="button"
                    @click="openEditModal = false"
                    class="px-4 py-2.5 bg-gray-100 rounded-xl font-medium text-gray-700 hover:bg-gray-200 transition"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-medium shadow-sm hover:bg-indigo-500 disabled:opacity-50 transition flex items-center gap-2"
                >
                    <span x-show="!form.processing">Save Changes</span>
                    <span x-show="form.processing" style="display: none;">Updating...</span>
                </button>
            </div>
        </form>
    </x-modal-2>
</div>
