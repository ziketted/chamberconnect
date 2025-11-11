<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventLikeController extends Controller
{
    public function toggle(Request $request, Event $event): JsonResponse
    {
        $user = auth()->user();
        
        if ($event->isLikedBy($user)) {
            // Retirer le like
            $event->likes()->detach($user->id);
            $liked = false;
        } else {
            // Ajouter le like
            $event->likes()->attach($user->id);
            $liked = true;
        }
        
        return response()->json([
            'liked' => $liked,
            'likes_count' => $event->likes()->count()
        ]);
    }
}