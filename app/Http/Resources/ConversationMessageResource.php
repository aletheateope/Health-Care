<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();
        $recipient_id = $this->conversation->participants
                             ->firstWhere('id', '!=', $user->id)->id;

        return [
            'id' => $this->id,
            'message' => $this->message,
            'sender' => $this->sender_id === $user->id ? 'me' : 'other',
            'recipient_id' => $this->sender_id === $user->id ? $recipient_id : $user->id,
            'created_at' => $this->created_at
        ];
    }
}
