<label for="{{ $for }}" {{ $attributes->merge(['class' => 'block text-gray-700 text-sm font-bold mb-2']) }}>
    {{ $slot->isNotEmpty() ? $slot : $fallback }}
</label>
