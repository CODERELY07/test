<div x-show="openCreateModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

    <div class="fixed inset-0 bg-gray-900/40 dark:bg-gray-950/60 backdrop-blur-sm" @click="openCreateModal = false"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="openCreateModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                class="relative w-full max-w-md transform rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-100 dark:border-gray-800/60 shadow-xl transition-all">

            <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800/60">
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 tracking-tight">Create New Ticket</h3>
                    <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">Register a new device into the maintenance loop.</p>
                </div>
                <button @click="openCreateModal = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition focus:outline-none">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form
                x-data="{
                    form: $form('post', '/repairs', {
                        name: '',
                        model: '',
                        category: '',
                        estimated_cost: '',
                        description: '',
                    }),

                    submitData() {
                        this.form.submit()
                            .then(response => {
                                this.form.reset();
                                openCreateModal = false
                                alert('Ticket created.')
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
                <div>
                    <label class="text-xs font-medium text-gray-600 dark:text-gray-400">Customer Name</label>
                    <input
                     id="name"
                     name="name"
                     x-model="form.name"
                     @change="form.validate('name')"
                    type="text" placeholder="John Doe" class="block mt-1.5 w-full rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-950 text-xs py-2.5 px-3.5 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition">
                    <template x-if="form.invalid('name')">
                        <div class="mt-1.5 text-xs font-medium text-red-400" x-text="form.errors.name"></div>
                    </template>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 dark:text-gray-400">Device Model</label>
                    <input
                     id="model"
                     name="model"
                     x-model="form.model"
                     @change="form.validate('model')" type="text" placeholder="iPhone 15 Pro Max" class="block mt-1.5 w-full rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-950 text-xs py-2.5 px-3.5 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition">
                    <template x-if="form.invalid('model')">
                        <div class="mt-1.5 text-xs font-medium text-red-400" x-text="form.errors.model"></div>
                    </template>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-gray-600 dark:text-gray-400">Category</label>
                        <input
                            id="category"
                            name="category"
                            x-model="form.category"
                            @change="form.validate('category')"
                        type="text" placeholder="Smartphone" class="block mt-1.5 w-full rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-950 text-xs py-2.5 px-3.5 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition">
                        <template x-if="form.invalid('category')">
                            <div class="mt-1.5 text-xs font-medium text-red-400" x-text="form.errors.category"></div>
                        </template>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600 dark:text-gray-400">Est. Cost ($)</label>
                        <input
                        id="estimated_cost"
                            name="estimated_cost"
                            x-model="form.estimated_cost"
                            @change="form.validate('estimated_cost')"
                        type="number" placeholder="150.00" class="block mt-1.5 w-full rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-950 text-xs py-2.5 px-3.5 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition">
                         <template x-if="form.invalid('estimated_cost')">
                            <div class="mt-1.5 text-xs font-medium text-red-400" x-text="form.errors.estimated_cost"></div>
                        </template>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 dark:text-gray-400">Description</label>
                    <input
                     id="description"
                     name="description"
                     x-model="form.description"
                     @change="form.validate('description')"
                    type="text" placeholder="John Doe" class="block mt-1.5 w-full rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-950 text-xs py-2.5 px-3.5 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition">
                    <template x-if="form.invalid('description')">
                        <div class="mt-1.5 text-xs font-medium text-red-400" x-text="form.errors.description"></div>
                    </template>
                </div>

                <div class="pt-3 flex items-center justify-end gap-2 border-t border-gray-100 dark:border-gray-800/60 mt-6">
                    <button type="button" @click="openCreateModal = false" class="px-4 py-2.5 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/60 text-xs font-semibold rounded-xl transition">
                        Cancel
                    </button>
                        <button :disabled="form.processing" class="px-4 py-2.5 bg-slate-600 hover:bg-slate-500 text-white text-xs font-semibold rounded-xl shadow-sm transition active:scale-[0.98]">
                        Register Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
