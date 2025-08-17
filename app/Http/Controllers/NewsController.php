<?php
   namespace App\Http\Controllers;
   use Illuminate\Http\Request;
   use Illuminate\Http\JsonResponse;
   use Illuminate\Support\Facades\DB;

   class NewsController extends Controller
   {
       public function index(): JsonResponse
       {
           return response()->json(['message' => 'News Route Is Working!']);
       }

       public function getNewsCards(): JsonResponse
       {
           try {
               $collection = DB::connection('mongodb')->selectCollection('newsAPI');
               $newsCards = $collection->find()->toArray();
               $formatted = array_map(function ($item) {
                   $item['_id'] = (string) $item['_id'];
                   return $item;
               }, $newsCards);
               return response()->json($formatted);
           } catch (\Exception $e) {
               return response()->json(['error' => $e->getMessage()], 500);
           }
       }

       public function getLatestNewsCards(): JsonResponse
       {
           try {
               $collection = DB::connection('mongodb')->selectCollection('newsAPI');
               $newsCards = $collection->find()->sort(['date' => -1])->limit(10)->toArray();
               $formatted = array_map(function ($item) {
                   $item['_id'] = (string) $item['_id'];
                   return $item;
               }, $newsCards);
               return response()->json($formatted);
           } catch (\Exception $e) {
               return response()->json(['error' => $e->getMessage()], 500);
           }
       }

       public function getSpecificNewsCard(Request $request, string $id): JsonResponse
       {
           try {
               $collection = DB::connection('mongodb')->selectCollection('newsAPI');
               $newsCard = $collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
               if (!$newsCard) {
                   return response()->json(['error' => 'News card not found'], 404);
               }
               $newsCard['_id'] = (string) $newsCard['_id'];
               return response()->json($newsCard);
           } catch (\Exception $e) {
               return response()->json(['error' => $e->getMessage()], 500);
           }
       }

       public function getSpecificNewsContent(Request $request, string $id): JsonResponse
       {
           try {
               $collection = DB::connection('mongodb')->selectCollection('newsContentAPI');
               $content = $collection->findOne(['id' => $id]);
               if (!$content) {
                   return response()->json(['error' => 'News content not found'], 404);
               }
               $content['_id'] = (string) $content['_id'];
               return response()->json($content);
           } catch (\Exception $e) {
               return response()->json(['error' => $e->getMessage()], 500);
           }
       }

       public function getSpecificNewsGallery(Request $request, string $id): JsonResponse
       {
           try {
               $collection = DB::connection('mongodb')->selectCollection('galleryAPI');
               $gallery = $collection->findOne(['id' => $id]);
               if (!$gallery) {
                   return response()->json(['error' => 'News gallery not found'], 404);
               }
               $gallery['_id'] = (string) $gallery['_id'];
               return response()->json($gallery);
           } catch (\Exception $e) {
               return response()->json(['error' => $e->getMessage()], 500);
           }
       }
   }