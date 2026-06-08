<x-app-layout>
    <div class="min-h-screen bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8 print:bg-white print:py-0">
        <div class="max-w-md mx-auto bg-white border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden print:border-0 print:shadow-none"
             x-data="{
                ticketNumber: '{{ $repair->ticket_number }}',

                convertToPngAndDownload() {
                    const svgElement = this.$refs.qrCanvasContainer.querySelector('svg');
                    if (!svgElement) return;

                    svgElement.setAttribute('width', '800');
                    svgElement.setAttribute('height', '800');

                    const svgString = new XMLSerializer().serializeToString(svgElement);

                    svgElement.removeAttribute('width');
                    svgElement.removeAttribute('height');

                    const svgBlob = new Blob([svgString], { type: 'image/svg+xml;charset=utf-8' });
                    const blobUrl = URL.createObjectURL(svgBlob);
                    const image = new Image();

                    image.onload = () => {
                        const canvas = document.createElement('canvas');
                        canvas.width = 800;
                        canvas.height = 800;
                        const ctx = canvas.getContext('2d');

                        ctx.fillStyle = '#FFFFFF';
                        ctx.fillRect(0, 0, 800, 800);
                        ctx.drawImage(image, 0, 0, 800, 800);

                        const pngUrl = canvas.toDataURL('image/png');
                        const link = document.createElement('a');
                        link.href = pngUrl;
                        const safeName = String(this.ticketNumber).replace(/[^a-z0-9]/gi, '_');
                        link.download = `QR_Tracking_${safeName}.png`;

                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(blobUrl);
                    };

                    image.src = blobUrl;
                }
             }">

            <div class="p-6 border-b border-dashed border-gray-200 text-center relative">
                <h2 class="text-sm font-black tracking-widest text-gray-400 uppercase">Repair Receipt</h2>
                <p class="mt-1.5 text-xl font-mono font-black text-gray-900" x-text="ticketNumber"></p>

                <div class="absolute -bottom-2 -left-2 w-4 h-4 bg-gray-50 rounded-full border-r border-gray-200/80 print:hidden"></div>
                <div class="absolute -bottom-2 -right-2 w-4 h-4 bg-gray-50 rounded-full border-l border-gray-200/80 print:hidden"></div>
            </div>

            <div class="p-6 space-y-6">
                <div class="flex flex-col items-center justify-center">
                    <div x-ref="qrCanvasContainer" class="w-48 h-48 bg-white border border-gray-100 p-3 rounded-xl shadow-inner flex items-center justify-center">
                        {!! $qrCodeSvg !!}
                    </div>
                    <p class="mt-2 text-[10px] font-medium text-gray-400 tracking-normal text-center max-w-[200px]">
                        Scan or upload this code on our platform to track this service live.
                    </p>
                </div>

                <div class="space-y-3 pt-2">
                    <div class="flex justify-between text-xs">
                        <span class="font-medium text-gray-400">Device Model</span>
                        <span class="font-bold text-gray-900">{{ $repair->model }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="font-medium text-gray-400">Category</span>
                        <span class="font-mono font-bold text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded text-[10px] uppercase">{{ $repair->category }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="font-medium text-gray-400">Job Status</span>
                        <span class="font-bold uppercase tracking-wider text-[10px] {{ $repair->status === 'completed' ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $repair->status }}
                        </span>
                    </div>
                </div>

                @php
                    $cleanCost = (float) str_replace(',', '', $repair->estimated_cost);
                    $cleanDownpayment = (float) str_replace(',', '', $repair->downpayment);
                @endphp

                <div class="border-t border-dashed border-gray-200 pt-4 space-y-3">
                    <div class="flex justify-between text-xs">
                        <span class="font-medium text-gray-400">Estimated Cost</span>
                        <span class="font-mono font-bold text-gray-900">₱{{ number_format($cleanCost, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="font-medium text-gray-400">Downpayment</span>
                        <span class="font-mono font-bold text-emerald-600">₱{{ number_format($cleanDownpayment, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-100 flex gap-3 print:hidden">
                <button type="button"
                        @click="window.print()"
                        class="flex-1 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 py-2.5 px-4 text-xs font-bold transition inline-flex items-center justify-center gap-2 shadow-sm active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.82l2.612-2.613m0 0l2.612 2.613M9.332 11.207V18m-6-6a9 9 0 1118 0 9 9 0 01-18 0z" />
                    </svg>
                    Print Ticket
                </button>

                <button type="button"
                        @click="convertToPngAndDownload()"
                        class="flex-1 rounded-xl bg-gray-900 hover:bg-gray-800 text-white py-2.5 px-4 text-xs font-bold transition inline-flex items-center justify-center gap-2 shadow-sm active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Save PNG Image
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
