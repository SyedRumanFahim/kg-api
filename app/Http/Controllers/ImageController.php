<?php
namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $images = Image::orderBy('date', 'desc')->get();
            return response()->json($images);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}