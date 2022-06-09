@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{ $post->title }}</div>

        <div class="card-body">
            @if (session('message'))
                <div class="alert alert-info">{{ session('message') }}</div>
            @endif

            @if ($post->url)
                <div class="mb-2">
                    <a href="{{ $post->url }}" target="_blank">{{ $post->url }}</a>
                </div>
            @endif

            @if ($post->image)
                <img src="{{ Storage::url($post->image) }}" />
                <br /><br />
            @endif

            {{ $post->post }}

            @auth
                <hr />
                <h3>Comments</h3>
                @forelse ($post->comments as $comment)
                    <b>{{ $comment->user->name }}</b>
                    <br />
                    {{ $comment->created_at->diffForHumans() }}
                    <p class="mt-2">{{ $comment->comment }}</p>
                @empty
                    No comments yet.
                @endforelse
                <hr />
                <form method="POST" action="{{ route('posts.comments.store', $post) }}">
                    @csrf
                    Add a comment:
                    <br />
                    <textarea class="form-control" name="comment" rows="5" required></textarea>
                    <br />
                    <button type="submit" class="btn btn-sm btn-primary">Add Comment</button>
                </form>
                <hr />

                @can('edit-post', $post)
                    <a href="{{ route('communities.posts.edit', [$post->community, $post]) }}" class="btn btn-sm btn-primary">
                        Edit post
                    </a>
                @endcan

                @can('delete-post', $post)
                    <form action="{{ route('communities.posts.destroy', [$post->community, $post]) }}" method="POST"
                        style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            Delete post
                        </button>
                    </form>
                @else
                    <form action="{{ route('post.report', $post) }}" method="POST" style="display: inline-block">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            Report post as inappropriate
                        </button>
                    </form>
                @endcan
            @endauth
        </div>
    </div>
@endsection
