<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hidehalo\Nanoid\Client;

use App\Models\User;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\Doctor;

use App\Http\Resources\ConversationResource;
use App\Http\Resources\ConversationMessageResource;

class ConversationController extends Controller
{
    public function findConversation(Request $request)
    {
        $user = Auth::user();
        $recipient_id = $request->recipient_id;

        $recipient = User::findOrFail($recipient_id);

        $conversation = Conversation::with('participants')
        ->whereHas('participants', fn ($q) => $q->where('users.id', $user->id))
        ->whereHas('participants', fn ($q) => $q->where('users.id', $recipient_id))
        ->first();


        if (!$conversation) {
            return response()->json([
                'exists' => false
            ]);
        }

        return response()->json([
            'exists' => true,
            'ref_id' => $conversation->ref_id
        ]);
    }

    public function myConversations(Request $request)
    {
        $user_id = $request->user()->id;

        $conversations = Conversation::whereHas('participants', function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        })
        ->with([
            'participants.profile',
            'latestMessage.user'
        ])
        ->orderByDesc(
            ConversationMessage::select('created_at')
                    ->whereColumn('conversation_messages.id', 'conversations.last_message_id')
                    ->limit(1)
        )
        ->get();


        return ConversationResource::collection($conversations);
    }

    public function myConversation(Request $request)
    {
        $validated = $request->validate([
            "conversation_id" => "required|string",
        ]);

        $conversation_id = $validated["conversation_id"];
        $conversation = Conversation::where('ref_id', $conversation_id)
         ->with(['participants',
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'asc');
                }]) // eager load
         ->first();


        if (!$conversation) {
            return response()->json([
                'error' => 'Conversation not found.'
            ], 404);
        }

        $user = Auth::user();

        $isParticipant = $conversation->participants->contains('id', $user->id);


        if (!$isParticipant) {
            return response()->json([
                'error' => 'Unauthorized access to this conversation.'
            ], 403);
        }

        $recipient = $conversation->participants()
            ->where('user_id', '!=', $user->id)
            ->first();

        $messages = ConversationMessageResource::collection($conversation->messages)
            ->additional(['recipient_id' => $recipient?->id]);

        return response()->json([
            'conversation_id' => $conversation->id,
            'recipient' => [
                'id' => $recipient?->id ?? null,
                'role' => $recipient?->role ?? 'unkown',
                'first_name' => $recipient?->profile?->first_name ?? 'Unknown',
                'last_name' => $recipient?->profile?->last_name ?? 'User',
            ],
            'messages' => $messages,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "conversation_id" => "required|string",
            "message" => "required|string",
            "recipient_id" => "nullable|integer|exists:users,id",
        ]);

        $user = Auth::user();

        $conversation_id = $validated["conversation_id"];
        $message = $validated["message"];


        if($conversation_id !== "new") {
            $conversation = Conversation::where('ref_id', $conversation_id)->firstOrFail();
        } else {
            $nanoid = new Client();
            $ref_id = $nanoid->generateId(10);
            $recipient_id = $validated["recipient_id"];
            $recipient = User::findOrFail($recipient_id);

            $conversation = Conversation::create([
                "ref_id" => $ref_id,
            ]);

            $conversation->participants()->syncWithoutDetaching([$user->id, $recipient->id]);
        }

        $newMessage = $conversation->messages()->create([
            "sender_id" => $user->id,
            "message" => $message,
        ]);

        $conversation->update([
            'last_message_id' => $newMessage->id,
        ]);

        return response()->json([
            "new" => $conversation_id === "new",
            "ref_id" => $conversation->ref_id,
            "message" => new ConversationMessageResource($newMessage),
       ]);

    }
}
