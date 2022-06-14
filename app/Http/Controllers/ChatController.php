<?php

namespace App\Http\Controllers;

use App\Events\MessageCreatedEvent;
use App\Events\MessageDeletedEvent;
use App\Models\Community;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
    public function index(Community $community)
    {
        return view('chat', compact('community'));
    }

    public function fetchMessages(Community $community)
    {
        $messages = Message::query()
            ->where('community_id', $community->id)
            ->with('user')
            ->withTrashed()
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request, Community $community)
    {
        $request->validate([
            'body' => 'required',
            // 'type' => 'required',
        ]);

        $message = Message::create([
            'type' => 'text',
            'from_id' => auth()->id(),
            'community_id' => $community->id,
            'body' => $request->body,
        ]);

        MessageCreatedEvent::broadcast($message);

        return response()->json([
            'message' => $message->load('user'),
        ]);
    }

    public function deleteMessage(Message $message)
    {
        abort_if($message->from_id != auth()->id(), 403);

        $message->delete();

        MessageDeletedEvent::broadcast($message);

        return response()->noContent();
    }
}
