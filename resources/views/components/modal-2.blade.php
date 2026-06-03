@props([
    'xShowName' => 'viewModal',
    'header' => '',
    'description' => ''
])
<div x-show="{{$xShowName}}"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

    <div class="fixed inset-0 bg-gray-900/40 dark:bg-gray-950/60 backdrop-blur-sm" @click="{{$xShowName}} = false"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="{{$xShowName}}"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                class="relative w-full max-w-md transform rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-100 dark:border-gray-800/60 shadow-xl transition-all">

            <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800/60">

                @if(isset($uniqueHeader))
                    {{ $uniqueHeader }}
                @else
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 tracking-tight">{{$header}}</h3>
                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">{{ $description }}</p>
                    </div>
                @endif
                <button @click="{{$xShowName}} = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition focus:outline-none">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
           {{ $slot }}
        </div>
    </div>
</div>
