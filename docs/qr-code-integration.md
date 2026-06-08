
# Complete Step-by-Step Tutorial: QR Code Generation, Upload, & Live Camera Tracking System

This guide walks you through setting up a complete, zero-server-storage tracking system using Laravel, Tailwind CSS, Alpine.js, and HTML5-QRcode.

## Part 1: Quick Copy-Paste Installation

Follow these steps to place the files in your project directory.

### Step 1: Create the Tracking Page (Where users search, upload, or scan)

Create a new file at `resources/views/track.blade.php` and paste this complete code:

HTML

```
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

```

### Step 2: Configure Server Routing Configuration

Open `routes/web.php` and copy-paste the receipt viewer endpoint layout logic below:

PHP

```
use App\Models\Repair;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/repair/{repair}/receipt', function(Repair $repair) {
    $qrCodeSvg = QrCode::format('svg')
        ->size(400)
        ->errorCorrection('H')
        ->generate($repair->ticket_number);

    return view('admin.repairs.receipt', [
        'repair' => $repair,
        'qrCodeSvg' => $qrCodeSvg
    ]);
})->name('repair.receipt');

```

### Step 3: Create the Receipt Generation View

Create a new file at `resources/views/admin/repairs/receipt.blade.php` and copy-paste this file:

HTML

```
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

```

## Part 2: Detailed Technical Explanation

Here is exactly how the data flows through the application functions.

### Code Module 1: The Receipt Page (SVG to PNG Converter Engine)

When you click **"Save PNG Image"**, the browser runs the `convertToPngAndDownload()` function inside AlpineJS.

#### 1. Targeting the Vector

JavaScript

```
const svgElement = this.$refs.qrCanvasContainer.querySelector('svg');

```

This looks inside your Alpine layout references (`x-ref="qrCanvasContainer"`) to isolate the raw code elements generated by Laravel.

#### 2. Scaling Up Resolution

JavaScript

```
svgElement.setAttribute('width', '800');
svgElement.setAttribute('height', '800');

```

Before processing, we temporarily inject explicit $800 \times 800$ attributes. This ensures that when the vector is converted into pixels, it scales up beautifully and stays crisp for phone cameras to scan.

#### 3. String Serialization & Blob Compilation

JavaScript

```
const svgString = new XMLSerializer().serializeToString(svgElement);
const svgBlob = new Blob([svgString], { type: 'image/svg+xml;charset=utf-8' });
const blobUrl = URL.createObjectURL(svgBlob);

```

-   **`XMLSerializer`** takes the live HTML code of the SVG and turns it into a plain text string.
    
-   **`Blob`** converts that raw text data package directly into a virtual file stream object inside memory.
    
-   **`URL.createObjectURL`** assigns a temporary web address to that virtual file so the browser can treat it like an ordinary image file.
    

#### 4. Drawing Onto a Pure Canvas Element

JavaScript

```
const canvas = document.createElement('canvas');
canvas.width = 800;
canvas.height = 800;
const ctx = canvas.getContext('2d');

ctx.fillStyle = '#FFFFFF';
ctx.fillRect(0, 0, 800, 800);
ctx.drawImage(image, 0, 0, 800, 800);

```

An invisible digital drawing canvas is created at $800 \times 800$ pixels. By default, canvas files are clear (transparent).

Because transparent files scan poorly on mobile screens in dark mode, `ctx.fillStyle = '#FFFFFF'` and `ctx.fillRect()` paints the background solid white before stamping the QR lines down on top of it using `ctx.drawImage()`.

#### 5. Executing the File Download Loop

JavaScript

```
const pngUrl = canvas.toDataURL('image/png');
const link = document.createElement('a');
link.href = pngUrl;
link.download = `QR_Tracking_${safeName}.png`;
document.body.appendChild(link);
link.click();

```

The canvas drawing board maps its pixel arrays out into a proper `data:image/png` base64 string layout representation.

A hidden link anchor element is injected into the DOM, pointing straight to that canvas data file string, automatically triggers a click download function, and immediately cleans itself up from memory allocation hooks.

### Code Module 2: Live Camera Scanning Engine

This module streams video directly from a hardware lens capture stream to decode codes in real-time.

#### 1. DOM Synchronization Guard

JavaScript

```
this.cameraActive = true;
await this.$nextTick();
this.html5ScannerInstance = new Html5Qrcode('camera-preview');

```

When `cameraActive` shifts to true, Alpine marks the camera container element to appear. However, the browser DOM takes a microsecond to render it. Calling `await this.$nextTick()` delays the initialization of `Html5Qrcode` until the element layout exists securely in the DOM, preventing targeting exceptions.

#### 2. Back-Facing Lens Routing

JavaScript

```
{ facingMode: 'environment' }

```

This configuration ensures that on mobile devices, the browser requests the main high-resolution **rear-facing camera lens** instead of default selfie/front lenses, providing optimal focal lengths for scan capture.

#### 3. Framing Frequency & Boundary Calculations

JavaScript

```
{ fps: 10, qrbox: { width: 250, height: 250 } }

```

-   **`fps: 10`**: Restricts the processing pipeline to sample only 10 frames per second. This maintains precise reading speeds while preventing CPU thermal throttling and heavy battery draw on older mobile chipsets.
    
-   **`qrbox`**: Overlays a visual target area on the interface, focusing the computation layout only on pixels within that square box to speed up matrix analysis.
    

### Code Module 3: Local Image File Parsing Engine

This module processes uploaded files completely inside local client memory.

#### 1. File Capture Sequence

JavaScript

```
const file = event.target.files?.[0] || event.dataTransfer?.files?.[0];

```

This standard safe navigation structure extracts files from **either** standard selection file upload picker inputs (`event.target.files`) **or** standard drag-and-drop actions (`event.dataTransfer.files`).

#### 2. Local Validation Guard

JavaScript

```
if (!file.type.startsWith('image/')) { ... }

```

A fast gatekeeper check that prevents processing if a user accidentally drops an invalid file type (like a `.pdf` or a `.docx`) into the dropzone.

#### 3. Memory Extraction Scan Block

JavaScript

```
const html5QrCode = new Html5Qrcode('qr-memory-engine');
html5QrCode.scanFile(file, true)

```

Instead of uploading the file to a Laravel controller via a heavy HTTP request, we instantiate an engine context linked to a hidden HTML element (`#qr-memory-engine`).

The `.scanFile(file, true)` method tells the library to read the file's raw pixels locally within the user's browser tabs, instantly identifying any code shapes.

#### 4. Automatic AJAX Execution Integration

JavaScript

```
.then(decodedText => {
    this.ticketNumber = String(decodedText).trim();
    this.searchTicket();
})

```

Once the library successfully decodes the QR code matrix into text, it assigns that string value straight to your Alpine `this.ticketNumber` model value. It then calls the `searchTicket()` function, which fires a standard background AJAX request to retrieve and display the records. All of this happens instantly without reloading the page or saving files to the server.
