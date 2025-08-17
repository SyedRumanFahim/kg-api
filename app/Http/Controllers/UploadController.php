<?php
   namespace App\Http\Controllers;
   use Illuminate\Http\Request;
   use Illuminate\Http\JsonResponse;
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\Storage;

   class UploadController extends Controller
   {
       public function index(): JsonResponse
       {
           return response()->json(['message' => 'Upload Route Is Working!']);
       }

       public function uploadNewsCover(Request $request): JsonResponse
       {
           try {
               $request->validate([
                   'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
               ]);

               $file = $request->file('image');
               $filename = $file->getClientOriginalName();
               $timestamp = time();
               $uniqueFilename = pathinfo($filename, PATHINFO_FILENAME) . '-' . $timestamp . '.' . $file->getClientOriginalExtension();
               $relativePath = 'uploads/news/' . $uniqueFilename;

               Storage::disk('public')->put($relativePath, file_get_contents($file));

               $collection = DB::connection('mongodb')->selectCollection('newsCovers');
               $result = $collection->insertOne([
                   'filename' => $uniqueFilename,
                   'relativePath' => $relativePath,
                   'original_name' => $filename,
                   'mime_type' => $file->getClientMimeType(),
                   'size' => $file->getSize(),
                   'uploaded_at' => now(),
               ]);

               return response()->json([
                   'message' => 'File uploaded successfully',
                   'filename' => $uniqueFilename,
                   'relativePath' => $relativePath,
                   'id' => (string) $result->getInsertedId(),
               ], 201);
           } catch (\Exception $e) {
               return response()->json(['error' => $e->getMessage()], 500);
           }
       }

       public function uploadCompany(Request $request): JsonResponse
       {
           // Implement similar logic for company uploads
           return response()->json(['message' => 'Not implemented'], 501);
       }

       public function uploadManagement(Request $request): JsonResponse
       {
           // Implement similar logic for management uploads
           return response()->json(['message' => 'Not implemented'], 501);
       }
   }