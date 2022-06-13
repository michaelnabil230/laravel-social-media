<?php

namespace App\Http\Livewire;

use App\Http\Requests\UpdateCommentRequest;
use App\Policies\CommentPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EditComment extends Component
{
    use AuthorizesRequests;

    public $comment;

    public $body;

    public function render()
    {
        return view('livewire.edit-comment');
    }

    protected $listeners = ['submitted' => 'updateComment'];

    public function updateComment($body)
    {
        $this->body = $body;
        $this->authorize(CommentPolicy::UPDATE, $this->comment);

        $this->validate((new UpdateCommentRequest())->rules());

        $this->comment->update([
            'body' => $this->body,
        ]);

        $this->emit('commentEdited');
    }
}
