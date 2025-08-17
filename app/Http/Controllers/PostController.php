<?php
namespace App\Http\Controllers;
use App\Models\NewsCard;
use App\Models\NewsContent;
use App\Models\NewsGallery;
use App\Models\Message;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['message' => 'Post Route Is Working!']);
    }

    public function postNewsIntro(Request $request): JsonResponse
    {
        try {
            $request->validate(['title' => 'required|string']);
            $collection = DB::connection('mongodb')->selectCollection('newsAPI');
            $result = $collection->insertOne($request->all());
            return response()->json(['id' => (string) $result->getInsertedId(), 'data' => $request->all()], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postNewsContent(Request $request): JsonResponse
    {
        try {
            $request->validate(['id' => 'required|string']);
            $collection = DB::connection('mongodb')->selectCollection('newsContentAPI');
            $result = $collection->insertOne($request->all());
            return response()->json(['id' => (string) $result->getInsertedId(), 'data' => $request->all()], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postNewsGallery(Request $request): JsonResponse
    {
        try {
            $request->validate(['id' => 'required|string']);
            $collection = DB::connection('mongodb')->selectCollection('galleryAPI');
            $result = $collection->insertOne($request->all());
            return response()->json(['id' => (string) $result->getInsertedId(), 'data' => $request->all()], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postCustomerMessage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'message' => 'required|string',
            ]);
            $collection = DB::connection('mongodb')->selectCollection('messagesAPI');
            $result = $collection->insertOne($request->all());
            return response()->json(['id' => (string) $result->getInsertedId(), 'data' => $request->all()], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postMailSubscriber(Request $request): JsonResponse
    {
        try {
            $request->validate(['email' => 'required|email']);
            $collection = DB::connection('mongodb')->selectCollection('subscriberAPI');
            $exists = $collection->findOne(['email' => $request->input('email')]);
            if ($exists) {
                return response()->json(['error' => 'Email already subscribed'], 422);
            }
            $result = $collection->insertOne($request->all());
            return response()->json(['id' => (string) $result->getInsertedId(), 'data' => $request->all()], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}