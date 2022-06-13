<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function pusherAuth()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // TODO
        return;
    }

    public function download($fileName)
    {
        abort_if(Storage::exists($fileName), 404, "Sorry, File does not exist in our server or may have been deleted!");

        return Storage::download($fileName);
    }

    public function send(Request $request)
    {
        $request->validate([
            'massage' => 'required',
            'to_id' => 'required',
            'type' => 'required',
            'attachment' => [
                'nullable',
                'sometimes',
                'file',
            ],
        ]);

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment')->store('messages/attachments');
        }

        Message::create([
            'type' => $request->type,
            'from_id' => auth()->id(),
            'to_id' => $request->to_id,
            'body' => htmlentities(trim($request->message), ENT_QUOTES, 'UTF-8'),
            'attachment' => isset($attachment) ? $attachment : null,
        ]);

        return response()->noContent();
    }

    public function fetch(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $messages = Message::query()
            ->fetchMessages($request->user_id)
            ->latest()
            ->paginate();

        return response()->json([
            'messages' => $messages,
            'last_message' => $messages->last(),
        ]);
    }

    public function seen(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        Message::makeSeen($request->id);

        return response()->noContent();
    }

    public function getContacts()
    {
        $users = Message::query()
            ->join('users',  function ($join) {
                $join
                    ->on('messages.from_id', 'users.id')
                    ->orOn('messages.to_id', 'users.id');
            })
            ->where(function ($q) {
                $q
                    ->where('messages.from_id', auth()->id())
                    ->orWhere('messages.to_id', auth()->id());
            })
            ->where('users.id', '!=', auth()->id())
            ->select('users.*', DB::raw('MAX(messages.created_at) max_created_at'))
            ->orderBy('max_created_at', 'desc')
            ->groupBy('users.id')
            ->paginate();

        return response()->json([
            'users' => $users,
        ]);
    }

    public function search(Request $request)
    {
        $getUsers = null;

        $users = User::query()
            ->where('id', '!=', auth()->id())
            ->where('name', 'LIKE', "%{$request->search}%")
            ->paginate();

        foreach ($users as $user) {
            $getUsers .= view('Chatify::layouts.listItem', [
                'get' => 'search_item',
                'type' => 'user',
                'user' => $user,
            ])->render();
        }

        if ($users->total() < 1) {
            $getUsers = '<p class="message-hint center-el"><span>Nothing to show.</span></p>';
        }

        return response()->json([
            'users' => $getUsers,
            'total' => $users->total(),
            'last_page' => $users->lastPage()
        ]);
    }

    public function deleteConversation(Request $request)
    {
        $delete = Message::fetchMessages($request->id)->delete();

        return response()->json([
            'is_deleted' => $delete,
        ]);
    }

    public function deleteMessage(Message $message)
    {
        $message->delete();

        return response()->noContent();
    }

    public function setActiveStatus(Request $request)
    {
        $query = User::where('id', $request->user_id);

        $update = $request['status'] > 0
            ? $query->update(['active_status' => 1])
            : $query->update(['active_status' => 0]);

        return response()->json([
            'status' => $update,
        ]);
    }
}
