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
    <!-- Backdrop -->
    <div
        class="fixed inset-0 bg-gray-500/30 backdrop-blur-md"
        @click="openEditModal = false">
    </div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div
            x-show="openEditModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="relative w-full max-w-md rounded-2xl bg-white p-6 border border-gray-200 shadow-xl text-gray-600"
        >

            <!-- Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <span
                        class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400"
                        x-text="form.ticket_number ? 'Editing: ' + form.ticket_number : 'Loading...'">
                    </span>

                    <h3 class="text-base font-bold text-gray-900 mt-1">
                        Edit Ticket Details
                    </h3>
                </div>

                <button
                    type="button"
                    @click="openEditModal = false"
                    class="text-gray-400 hover:text-gray-600 transition">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submitUpdate()" class="mt-4 space-y-4 text-xs">

                @csrf

                <!-- Customer Name -->
                <div>
                    <label class="block text-gray-400 font-medium mb-1.5">
                        Customer Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        x-model="form.name"
                        @change="form.validate?.('name')"
                        class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900">

                    <template x-if="form.invalid?.('name')">
                        <div class="mt-1 text-red-500 text-xs"
                             x-text="form.errors.name"></div>
                    </template>
                </div>

                <!-- Model + Category -->
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-gray-400 font-medium mb-1.5">
                            Device Model
                        </label>

                        <input
                            type="text"
                            x-model="form.model"
                            @change="form.validate?.('model')"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl">
                        <template x-if="form.invalid?.('model')">
                            <div class="mt-1 text-red-500 text-xs"
                                x-text="form.errors.model"></div>
                        </template>
                    </div>

                    <div>
                        <label class="block text-gray-400 font-medium mb-1.5">
                            Device Category
                        </label>

                        <input
                            type="text"
                            x-model="form.category"
                            @change="form.validate?.('category')"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl">
                        <template x-if="form.invalid?.('category')">
                            <div class="mt-1 text-red-500 text-xs"
                                x-text="form.errors.category"></div>
                        </template>
                    </div>

                </div>

                <!-- Cost + Status -->
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-gray-400 font-medium mb-1.5">
                            Estimated Cost (₱)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            x-model="form.estimated_cost"
                            @change="form.validate?.('estimated_cost')"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl">

                        <template x-if="form.invalid?.('estimated_cost')">
                            <div class="mt-1 text-red-500 text-xs"
                                x-text="form.errors.estimated_cost"></div>
                        </template>
                    </div>

                    <div>
                        <label class="block text-gray-400 font-medium mb-1.5">
                            Ticket Status
                        </label>

                        <select
                            x-model="form.status"
                            @change="form.validate?.('status')"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl">

                            <option value="pending">PENDING</option>
                            <option value="ongoing">ONGOING</option>
                            <option value="completed">COMPLETED</option>
                        </select>
                    </div>

                </div>

                <!-- Description -->
                <div>
                    <label class="block text-gray-400 font-medium mb-1.5">
                        Problem Description
                    </label>

                    <textarea
                        rows="3"
                        x-model="form.description"
                        @change="form.validate?.('description')"
                        class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl">
                    </textarea>
                    <template x-if="form.invalid?.('description')">
                        <div class="mt-1 text-red-500 text-xs"
                            x-text="form.errors.description"></div>
                    </template>
                </div>

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
        </div>
    </div>
</div>
