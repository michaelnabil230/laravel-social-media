@push('modals')
    <div class="modal" x-show="activeModal == '{{ $identifier }}'" x-cloak>
        <div class="modal-content" x-on:click.outside="activeModal = false">
            <form action="{{ $action }}" method="{{ $method() }}">
                @csrf
                <div class="flex flex-col justify-between h-full">
                    <div class="overflow-auto">
                        <div class="modal-header">
                            <button type="button" class="close" aria-hidden="true"
                                x-on:click.prevent="activeModal = false">&times;
                            </button>
                            <h4 class="modal-title">{{ $title }}</h4>
                        </div>

                        <div class="modal-body">
                            {{ $slot }}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="text-gray-600 mr-4"
                            x-on:click.prevent="activeModal = false">Cancel</button>

                        <button type="submit"
                            class="button {{ $type === 'delete' ? 'button-danger' : 'button-primary' }}">{{ $submit ?? $title }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush
