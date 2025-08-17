<?php
namespace App\Http\Controllers;
use App\Models\NewsCard;
use App\Models\NewsContent;
use App\Models\NewsGallery;
use Illuminate\Http\JsonResponse;

class DeleteController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['message' => 'Delete Route Is Working!']);
    }

    public function deleteNewsIntro(string $id): JsonResponse
    {
        try {
            $newsCard = NewsCard::findOrFail($id);
            $newsCard->delete();
            return response()->json(['message' => 'News Card deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'News card not found'], 404);
        }
    }

    public function deleteNewsContent(string $id): JsonResponse
    {
        try {
            $newsContent = NewsContent::where('id', $id)->firstOrFail();
            $newsContent->delete();
            return response()->json(['message' => 'News content deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'News content not found'], 404);
        }
    }

    public function deleteNewsGallery(string $id): JsonResponse
    {
        try {
            $newsGallery = NewsGallery::where('id', $id)->firstOrFail();
            $newsGallery->delete();
            return response()->json(['message' => 'News gallery deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'News gallery not found'], 404);
        }
    }
}