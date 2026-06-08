<div class="bg-white rounded-2xl border border-gray-200/60 p-6 shadow-sm flex flex-col justify-between">
    <div>
        <h3 class="text-[10px] font-mono font-bold uppercase tracking-wider text-gray-400 mb-4">Device Information</h3>
        <dl class="space-y-3.5 text-xs">
            <div class="flex justify-between items-center">
                <dt class="font-medium text-gray-400">Device Model</dt>
                <dd class="font-bold text-gray-900" x-text="repair.model"></dd>
            </div>
            <div class="flex justify-between items-center">
                <dt class="font-medium text-gray-400">Category</dt>
                <dd class="font-mono text-[11px] font-bold text-gray-500 uppercase bg-gray-50 border border-gray-100 px-2 py-0.5 rounded-md" x-text="repair.category"></dd>
            </div>
            <div class="pt-3.5 border-t border-gray-100">
                <dt class="font-medium text-gray-400 mb-1.5">Reported Issue</dt>
                <dd class="font-medium text-gray-600 leading-relaxed bg-gray-50/50 p-3 rounded-xl border border-gray-100/80" x-text="repair.description || 'No description provided.'"></dd>
            </div>
        </dl>
    </div>
</div>
