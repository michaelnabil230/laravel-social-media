<div>
    <div class="relative">
        @if ($attributes->get('prefix-icon'))
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="{{ $attributes->get('prefix-icon') }} h-5 w-5 text-gray-400"></i>
            </div>
        @endif

        <input name="{{ $name }}" type="{{ $type }}" id="{{ $id }}"
            @if (isset($value)) value="{{ $value }}" @endif
            {{ $attributes->merge([
                'class' =>
                    'block w-full border-gray-300 rounded-md focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 sm:text-sm sm:leading-5 mt-1' .
                    ($attributes->get('prefix-icon') ? ' pl-10' : '') .
                    ($errors->has($name)
                        ? ' border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500'
                        : ''),
            ]) }} />

        @if ($errors->has($name))
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-circle-exclamation h-5 w-5 text-red-500"></i>
            </div>
        @endif
    </div>

    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <x-forms.error>
                {{ $error }}
            </x-forms.error>
        @endforeach
    @endif
</div>
