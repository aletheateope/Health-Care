<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_id = $request->user()->id;

        $otherParticipants = $this->participants
            ->where('id', '!=', $user_id)
            ->map(fn ($user) => [
                'id' => $user->id,
                'first_name' => $user->profile->first_name,
                'last_name' => $user->profile->last_name,
            ])
            ->values();


        return [
            'id' => $this->id,
            'ref_id' => $this->ref_id,
            'participant' => $otherParticipants->first(),
            'last_message' =>  [
                'message' => $this->latestMessage->message,
                'sender_id' => $this->latestMessage->sender_id,
                'created_at'=> $this->latestMessage->created_at
            ]
        ];
    }


}
