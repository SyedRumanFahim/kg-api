<?php
namespace App\Http\Controllers;
use App\Models\Message;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;

class SocialController extends Controller
{
    public function getMessages(): JsonResponse
    {
        try {
            $messages = Message::orderBy('date', 'desc')->get();
            return response()->json($messages);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSubscribers(): JsonResponse
    {
        try {
            $subscribers = Subscriber::get();
            return response()->json($subscribers);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}