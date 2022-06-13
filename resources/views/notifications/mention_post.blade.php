@php($data = $notification->data)

<tr>
    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm leading-5 text-gray-600">
        <div class="flex items-center">
            <i class="fa-solid fa-reply w-5 h-5 mr-4"></i>
            <div>
                You are mentioned in a post on {{ $data['post']['title'] }}
                <a href="{{ route('posts.show', $data['post']['id']) }}" class="text-green-700">
                    show post now
                </a>.
            </div>
        </div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm leading-5 text-gray-600">
        {{ $notification->created_at->diffForHumans() }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm leading-5 text-gray-600 text-right">
        <div class="flex justify-end">
            <button wire:click="markAsRead('{{ $notification->id }}')" class="text-green-500">
                <i class="fa-solid fa-check w-5 h-5"></i>
            </button>
        </div>
    </td>
</tr>
