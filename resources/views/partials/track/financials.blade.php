<div class="bg-white rounded-2xl border border-gray-200/60 p-6 shadow-sm flex flex-col justify-between">
    <div>
        <h3 class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400 mb-4">Financial Breakdown</h3>
        <dl class="space-y-3.5 text-xs">
            <div class="flex justify-between items-center">
                <dt class="font-medium text-gray-400">Total Estimated Cost</dt>
                <dd class="font-mono font-bold text-gray-900" x-text="'₱' + totalCost.toFixed(2)"></dd>
            </div>
            <div class="flex justify-between items-center">
                <dt class="font-medium text-gray-400">Downpayment Paid</dt>
                <dd class="font-mono font-bold text-emerald-600" x-text="'₱' + downpayment.toFixed(2)"></dd>
            </div>

            <div class="pt-3.5 border-t border-gray-100">
                <dt class="font-medium text-gray-400 mb-1.5">Payment Ledger Status</dt>
                <dd>
                    <span x-show="paymentStatus === 'paid'" class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] tracking-wider px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Fully Paid
                    </span>
                    <span x-show="paymentStatus === 'partial'" class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] tracking-wider px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Partially Paid
                    </span>
                    <span x-show="paymentStatus === 'unpaid'" class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] tracking-wider px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Unpaid
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-4">
        <span class="text-xs font-bold text-gray-900">Remaining Balance Due</span>
        <span class="text-xl font-mono font-black" :class="balanceDue <= 0 ? 'text-emerald-600' : 'text-red-600'" x-text="'₱' + balanceDue.toFixed(2)"></span>
    </div>
</div>
