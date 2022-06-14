@props(['post', 'comment'])

<div class="bg-white shadow rounded" id="{{ $comment->id }}" x-data="{ edit: false }">
    <div class="border-b">
        <div class="flex flex-row justify-between items-center px-6 py-2.5">
            <div>
                <div class="flex flex-col lg:flex-row lg:items-center">
                    <div class="flex items-center">
                        <a href="{{ route('profile', $comment->user->username) }}" class="hover:underline">
                            <span class="text-gray-900 mr-5">{{ $comment->user->username }}</span>
                        </a>
                    </div>
                    <a href="#{{ $comment->id }}"
                        class="font-mono text-gray-700 hover:text-green-500 hover:underline mt-1 lg:mt-0">
                        {{ $comment->created_at->diffForHumans() }}
                    </a>
                </div>
            </div>

            <div class="flex items-center lg:gap-x-3">
                @if ($comment->user->is_admin)
                    <span class="text-sm text-green-500 border border-green-200 rounded py-1.5 px-3 leading-none">
                        Admin
                    </span>
                @endif

                @can(App\Policies\CommentPolicy::UPDATE, $comment)
                    <div class="relative -mr-3" x-data="{ open: false }" x-on:click.outside="open = false">

                        <button class="p-2 rounded hover:bg-gray-100" x-on:click="open = !open">
                            <i class="fa-solid fa-ellipsis-vertical w-6 h-6"></i>
                        </button>

                        <div x-cloak x-show="open"
                            class="absolute top-12 right-1 flex flex-col bg-white rounded shadow w-48 z-10">

                            <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100"
                                x-on:click="edit = !edit; open = false;">
                                <i class="fa-solid fa-pencil w-6 h-6"></i>
                                <span x-text="edit ? 'Cancel editing' : 'Edit'"></span>
                            </button>

                            <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100"
                                x-on:click="activeModal = 'deleteComment-{{ $comment->id }}'">
                                <i class="fa-solid fa-trash w-6 h-6 text-red-500"></i>
                                Delete
                            </button>
                        </div>
                    </div>

                    <x-modal identifier="deleteComment-{{ $comment->id }}" :action="route('posts.comments.destroy', [$post, $comment])" title="Delete Comment">
                        <p>Are you sure you want to delete this comment? This cannot be undone.</p>
                    </x-modal>
                @endcan
            </div>
        </div>
    </div>

    <livewire:edit-comment :comment="$comment" />
</div>
