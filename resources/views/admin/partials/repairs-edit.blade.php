<div
x-data="{
openEditModal: false,
form: null,

createForm(id = 0) {
    return $form('patch', `/repairs/${id}`, {
        id: '',
        ticket_number: '',
        name: '',
        model: '',
        category: '',
        estimated_cost: '',
        description: '',
        status: ''
    });
},

init() {
    this.form = this.createForm();
},

openModal(data) {

    // rebuild form with correct endpoint
    this.form = this.createForm(data.id);

    // populate values
    this.form.id = data.id;
    this.form.ticket_number = data.ticket_number ?? '';
    this.form.name = data.name ?? '';
    this.form.model = data.model ?? '';
    this.form.category = data.category ?? '';
    this.form.estimated_cost = Number(data.estimated_cost ?? 0);
    this.form.description = data.description ?? '';
    this.form.status = data.status ?? 'pending';

    this.openEditModal = true;
},

submitUpdate() {

    console.log('Submitting to ID:', this.form.id);

    this.form.submit()
        .then(() => {
            this.openEditModal = false;
            alert('Ticket successfully updated!');
            window.location.reload();
        })
        .catch(error => {
            console.error('Update Error:', error);
        });
}
}"

@open-edit-repair-modal.window="
openModal($event.detail)
"
x-show="openEditModal"
class="fixed inset-0 z-50 overflow-y-auto"
style="display:none;"
>
<x-modal-2 xShowName="openEditModal" >
    <x-slot:uniqueHeader>
        <div>
            <span
                class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400"
                x-text="form.ticket_number ? 'Editing: ' + form.ticket_number : 'Loading...'">
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
                </div>

                <x-input-with-validation model="description" label="Problem Description" placeholder="Describe the device fault..." />
            <!-- Buttons -->
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100">

                <button
                    type="button"
                    @click="openEditModal = false"
                    class="px-4 py-2.5 bg-gray-100 rounded-xl">
                    Cancel
                </button>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="px-4 py-2.5 bg-indigo-600 text-white rounded-xl disabled:opacity-50">

                    <span x-show="!form.processing">
                        Save Changes
                    </span>

                    <span x-show="form.processing">
                        Updating...
                    </span>
                </button>

            </div>
        </form>
</x-modal-2>

