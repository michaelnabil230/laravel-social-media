<div>
    <div x-show="!edit" x-data x-init="$nextTick(function() { highlightCode($el); });
    $watch('edit', function() { highlightCode($el); });
    $wire.on('commentEdited', function() {
        show = true;
        edit = false;
    });" class="prose prose-lio max-w-none p-6 break-words">
        {!! replace_links(md_to_html($comment->body)) !!}
    </div>

    @can(App\Policies\CommentPolicy::UPDATE, $comment)
        <div x-show="edit">
            <livewire:editor x-cloak :hasShadow="false" :body="$comment->body" hasMentions hasButton buttonLabel="Update comment"
                buttonIcon="heroicon-o-arrow-right" />

            @if ($errors->has('body'))
                @foreach ($errors->get('body') as $error)
                    <x-forms.error class="px-6 pb-4">{{ $error }}</x-forms.error>
                @endforeach
            @endif
        </div>
    @endcan
</div>
