<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8"
         x-data="{
            searched: false, ticketNumber: '', loading: false, repair: null,

            parseValue(val) {
                return parseFloat(String(val || 0).replace(/,/g, '')) || 0;
            },
            get totalCost() { return this.parseValue(this.repair?.estimated_cost); },
            get downpayment() { return this.parseValue(this.repair?.downpayment); },
            get balanceDue() { return Math.max(0, this.totalCost - this.downpayment); },
            get paymentStatus() {
                if (this.downpayment <= 0) return 'unpaid';
                return this.downpayment >= this.totalCost ? 'paid' : 'partial';
            },
            async searchTicket() {
                if (!this.ticketNumber.trim()) return;
                this.loading = true; this.searched = false;
                try {
                    let response = await fetch('/track-repair/' + encodeURIComponent(this.ticketNumber));
                    this.repair = await response.json();
                } catch (error) {
                    this.repair = { found: false };
                } finally {
                    this.searched = true; this.loading = false;
                }
            }
         }">

        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Track Your Repair</h1>
                <p class="mt-2 text-sm text-gray-500 font-medium">Enter your tracking identifier to check real-time status.</p>
            </div>

            @include('partials.track.search-form')

            <div x-show="searched" x-transition x-cloak class="space-y-6">

                <template x-if="repair && repair.found">
                    <div class="space-y-6">
                        @include('partials.track.status-card')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @include('partials.track.device-info')

                            @include('partials.track.financials')
                        </div>

                        <p class="text-center text-[11px] text-gray-400 font-medium pt-4">
                            Have questions about your calculation matrix? Please contact support.
                        </p>
                    </div>
                </template>

                <template x-if="repair && !repair.found">
                    <div class="bg-white rounded-2xl border border-gray-200/60 p-12 text-center shadow-sm">
                        <div class="inline-flex p-3 rounded-xl bg-amber-500/5 text-amber-500 mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        </div>
                        <h3 class="text-sm font-black text-gray-900 tracking-tight">No Record Discovered</h3>
                        <p class="text-xs text-gray-400 font-medium mt-1 max-w-sm mx-auto">We couldn't find logs matching reference identifier <span class="font-mono font-bold text-gray-600" x-text="'&quot;' + ticketNumber + '&quot;'"></span>.</p>
                    </div>
                </template>

            </div>
        </div>
    </div>
</x-guest-layout>
