<x-modal-2 xShowName="openCreateModal" header="Create New Ticket" description="Register a new device into the maintenance loop.">
      <form
        x-data="{
            form: $form('post', '/repairs', {
                name: '',
                model: '',
                category: '',
                estimated_cost: '',
                description: '',
                downpayment: '',
            }),

            submitData() {
                this.form.submit()
                    .then(response => {
                        this.form.reset();
                        this.openCreateModal.modal = false;
                        alert('Ticket created.');
                        window.location.reload();
                    })
                    .catch(error => {
                    });
            },

        }"
        @submit.prevent="submitData()"
        class="mt-4 space-y-4"
        >
        @csrf
        <x-input-with-validation model="name" type="text" placeholder="Jun Fruds" label="Customer Name"/>
        <div class="grid grid-cols-2 gap-4">
            <x-input-with-validation model="category" type="text" placeholder="Smartphone" label="Category"/>
            <x-input-with-validation model="model" type="text" placeholder="iPhone 15 Pro Max" label="Device Model"/>
        </div>
        <div class="grid grid-cols-2 gap-4">
                <x-input-with-validation model="estimated_cost" type="number" placeholder="150.00" label="Est. Cost (₱)"/>
                <x-input-with-validation model="downpayment" type="number"  placeholder="150.00" label="Downpayment (₱)"/>
        </div>

        <x-input-with-validation model="description" type="text" placeholder="LCD issue" label="Description"/>

         <div class="pt-3 flex items-center justify-end gap-2 border-t border-gray-100 dark:border-gray-800/60 mt-6">
            <button type="button" @click="openCreateModal = false" class="px-4 py-2.5 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/60 text-xs font-semibold rounded-xl transition">
                Cancel
            </button>
                <button :disabled="form.processing" class="px-4 py-2.5 bg-slate-600 hover:bg-slate-500 text-white text-xs font-semibold rounded-xl shadow-sm transition active:scale-[0.98]">
                Register Ticket
            </button>
        </div>
    </form>
</x-modal-2>
