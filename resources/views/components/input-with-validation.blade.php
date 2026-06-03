@props([
    'model',
    'type' => 'text',
    'placeholder' => '...',
    'label' => 'label'
])
<div>
    <label class="text-xs font-medium text-gray-600 dark:text-gray-400">{{$label}}</label>
    <input
        id="{{ $model }}"
        name="{{ $model }}"
        x-model="form.{{ $model }}"
        @change="form.validate('{{ $model }}')"
    type="{{ $type }}" placeholder="{{ $placeholder }}" class="block mt-1.5 w-full rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-950 text-xs py-2.5 px-3.5 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition">
    <template x-if="form.invalid('{{ $model }}')">
        <div class="mt-1.5 text-xs font-medium text-red-400" x-text="form.errors.{{ $model }}"></div>
    </template>
</div>