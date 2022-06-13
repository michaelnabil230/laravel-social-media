@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => 'flex items-center text-base text-gray-300']) }}>
        <span class="text-gray-700 mr-1 hover:text-gray-500">{{ $slot }}</span>
        <i class="fa-solid fa-arrow-right w-4 h-4 fill-current"></i>
    </a>
@else
    <button {{ $attributes->merge(['class' => 'flex items-center text-base text-gray-300']) }}>
        <span class="text-gray-700 mr-1 hover:text-gray-500">{{ $slot }}</span>
        <i class="fa-solid fa-arrow-right w-4 h-4 fill-current"></i>
    </button>
@endif
