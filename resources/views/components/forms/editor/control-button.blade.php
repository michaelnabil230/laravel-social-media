<x-buttons.primary-button title="{{ $title }}" type="button" class="text-gray-900 cursor-pointer"
    x-on:click="handleClick('{{ $control }}')">
    <i class="{{ $icon }} w-5 h-5 md:w-6 md:h-6"></i>
</x-buttons.primary-button>
