@props([
    'tag' => 'a',
    'selected' => false,
])

<{{ $tag }} {{ $attributes }}
    class="@if ($selected) text-green-500 @endif flex rounded-full p-3 transition duration-300 ease-in-out hover:text-green-500 hover:bg-green-100 hover:opacity-50">
    {{ $slot }}
    </{{ $tag }}>
