<script src="https://unpkg.com/html5-qrcode" defer></script>

<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8"
         x-data="{
            searched: false,
            ticketNumber: '',
            cameraActive: false,
            html5ScannerInstance: null,
            uploadError: '',
            loading: false,
            repair: null,
            dragActive: false,

            async toggleCameraScanner() {
                if (this.cameraActive) {
                    this.stopCamera();
                } else {
                    this.cameraActive = true;
                    this.uploadError = '';
                    this.searched = false;
                    await this.$nextTick();

                    this.html5ScannerInstance = new Html5Qrcode('camera-preview');
                    this.html5ScannerInstance.start(
                        { facingMode: 'environment' },
                        { fps: 10, qrbox: { width: 250, height: 250 } },
                        (decodedText) => {
                            this.ticketNumber = String(decodedText).trim();
                            this.stopCamera();
                            this.searchTicket();
                        },
                        (errorMessage) => {}
                    ).catch(err => {
                        this.uploadError = 'Camera access denied or video device unavailable.';
                        this.cameraActive = false;
                    });
                }
            },

            stopCamera() {
                if (this.html5ScannerInstance) {
                    this.html5ScannerInstance.stop().then(() => {
                        this.html5ScannerInstance = null;
                        this.cameraActive = false;
                    }).catch(err => console.error(err));
                } else {
                    this.cameraActive = false;
                }
            },

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
                this.loading = true; this.searched = false; this.uploadError = '';
                try {
                    let response = await fetch('/track-repair/' + encodeURIComponent(this.ticketNumber));
                    this.repair = await response.json();
                } catch (error) {
                    this.repair = { found: false };
                } finally {
                    this.searched = true; this.loading = false;
                }
            },
            processQrFile(event) {
                const file = event.target.files?.[0] || event.dataTransfer?.files?.[0];
                this.dragActive = false;
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    this.uploadError = 'Please upload a valid PNG image receipt.';
                    return;
                }

                this.loading = true;
                this.uploadError = '';

                const html5QrCode = new Html5Qrcode('qr-memory-engine');
                html5QrCode.scanFile(file, true)
                    .then(decodedText => {
                        this.ticketNumber = String(decodedText).trim();
                        this.searchTicket();
                    })
                    .catch(err => {
                        this.uploadError = 'Could not locate a recognizable tracking QR code in this image.';
                        this.loading = false;
                    });
            }
         }"
         x-init="$watch('searched', value => { if(value && cameraActive) stopCamera(); })">

        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Track Your Repair</h1>
                <p class="mt-2 text-sm text-gray-500 font-medium">Enter your code, drop your receipt, or scan live with your camera.</p>
            </div>

            <div id="qr-memory-engine" class="hidden"></div>

            <div x-show="cameraActive" x-cloak class="mb-8 bg-black rounded-2xl overflow-hidden border border-gray-800 shadow-xl relative">
                <div id="camera-preview" class="w-full h-auto min-h-[300px]"></div>
                <button type="button" @click="stopCamera()" class="absolute top-4 right-4 z-20 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-3 py-1.5 rounded-xl shadow transition active:scale-95">
                    Close Scanner
                </button>
            </div>

            <div x-show="!cameraActive" class="grid grid-cols-1 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-gray-200/60 p-6 shadow-sm flex flex-col justify-center">
                    <form @submit.prevent="searchTicket()" class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.604 10.604z" />
                                </svg>
                            </div>
                            <input type="text" x-model="ticketNumber" required placeholder="e.g., #2026-002"
                                   class="block w-full rounded-xl border border-gray-200 bg-gray-50/30 py-3 pl-10 pr-3 text-sm font-medium text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" :disabled="loading" class="flex-1 sm:flex-none rounded-xl bg-gray-900 px-6 py-3 text-sm font-bold text-white hover:bg-gray-800 transition active:scale-[0.99] shadow-sm disabled:opacity-50 inline-flex items-center justify-center gap-2">
                                <span x-show="!loading">Search Ticket</span>
                                <span x-show="loading" style="display: none;" class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                            </button>
                            <button type="button" @click="toggleCameraScanner()" class="rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 text-sm font-bold transition active:scale-[0.99] shadow-sm inline-flex items-center justify-center gap-2 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                </svg>
                                Scan QR
                            </button>
                        </div>
                    </form>
                </div>

                <div :class="dragActive ? 'border-indigo-500 bg-indigo-50/30' : 'border-gray-200 bg-white hover:bg-gray-50/50'"
                     @dragover.prevent="dragActive = true"
                     @dragleave.prevent="dragActive = false"
                     @drop.prevent="processQrFile($event)"
                     class="border-2 border-dashed rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer relative transition-all duration-150 min-h-[200px] shadow-sm">

                    <input type="file" accept="image/*" @change="processQrFile($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" :disabled="loading" />

                    <div x-show="!loading" class="flex flex-col items-center space-y-1">
                        <svg class="w-20 h-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <p class="text-lg font-bold text-indigo-600">Drop or Upload QR Image</p>
                        <p class="text-sm text-gray-400 font-medium">Scans locally inside memory</p>
                    </div>

                    <div x-show="loading && !searched" style="display: none;" class="flex flex-col items-center space-y-1">
                        <span class="h-4 w-4 animate-spin rounded-full border-2 border-indigo-600 border-t-transparent"></span>
                        <p class="text-[10px] font-bold text-gray-600">Reading image data...</p>
                    </div>
                </div>
            </div>

            <div x-show="uploadError" x-cloak x-transition class="mb-6 p-3 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-xs font-medium flex items-start gap-2">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                <span x-text="uploadError"></span>
            </div>

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
