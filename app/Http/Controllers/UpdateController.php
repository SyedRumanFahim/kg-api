<?php
namespace App\Http\Controllers;
use App\Models\NewsCard;
use App\Models\NewsContent;
use App\Models\NewsGallery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;

class UpdateController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['message' => 'Update Route Is Working!']);
    }

    public function updateNewsIntro(Request $request, string $id): JsonResponse
    {
        try {
            $collection = DB::connection('mongodb')->selectCollection('newsAPI');
            /** @var \MongoDB\BSON\ObjectId $objectId */
            $objectId = new ObjectId($id);
            $result = $collection->updateOne(
                ['_id' => $objectId],
                ['$set' => $request->all()]
            );
            return response()->json(['message' => $result->getModifiedCount() > 0 ? 'News updated successfully' : 'No changes detected']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateNewsContent(Request $request, string $id): JsonResponse
    {
        try {
            $collection = DB::connection('mongodb')->selectCollection('newsContentAPI');
            $result = $collection->updateOne(
                ['id' => $id],
                ['$set' => $request->all()]
            );
            return response()->json(['message' => $result->getModifiedCount() > 0 ? 'News content updated successfully' : 'No changes detected']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateNewsGallery(Request $request, string $id): JsonResponse
    {
        try {
            $collection = DB::connection('mongodb')->selectCollection('galleryAPI');
            $result = $collection->updateOne(
                ['id' => $id],
                ['$set' => $request->all()]
            );
            return response()->json(['message' => $result->getModifiedCount() > 0 ? 'News gallery updated successfully' : 'No changes detected']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}