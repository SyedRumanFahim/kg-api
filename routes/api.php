<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UploadController;

Route::get('/', function () {
    try {
        $db = DB::connection('mongodb')->getMongoClient()->selectDatabase(env('MONGODB_DATABASE', 'krishitest'));
        $collections = iterator_to_array($db->listCollections());
        $collectionNames = array_map(fn($col) => $col->getName(), $collections);
        return response()->json(['message' => "Collections in the 'krishitest' database: " . implode(', ', $collectionNames)]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/newsCards', [NewsController::class, 'getNewsCards']);
    Route::get('/latestNews', [NewsController::class, 'getLatestNewsCards']);
    Route::get('/newsCards/{id}', [NewsController::class, 'getSpecificNewsCard']);
    Route::get('/newsContent/{id}', [NewsController::class, 'getSpecificNewsContent']);
    Route::get('/newsGallery/{id}', [NewsController::class, 'getSpecificNewsGallery']);
});

Route::prefix('post')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::post('/newsCards', [PostController::class, 'postNewsIntro']);
    Route::post('/newsContent', [PostController::class, 'postNewsContent']);
    Route::post('/newsGallery', [PostController::class, 'postNewsGallery']);
    Route::post('/customerMessage', [PostController::class, 'postCustomerMessage']);
    Route::post('/subscribers', [PostController::class, 'postMailSubscriber']);
});

Route::prefix('update')->group(function () {
    Route::get('/', [UpdateController::class, 'index']);
    Route::put('/newsCards/{id}', [UpdateController::class, 'updateNewsIntro']);
    Route::put('/newsContent/{id}', [UpdateController::class, 'updateNewsContent']);
    Route::put('/newsGallery/{id}', [UpdateController::class, 'updateNewsGallery']);
});

Route::prefix('delete')->group(function () {
    Route::get('/', [DeleteController::class, 'index']);
    Route::delete('/newsCards/{id}', [DeleteController::class, 'deleteNewsIntro']);
    Route::delete('/newsContent/{id}', [DeleteController::class, 'deleteNewsContent']);
    Route::delete('/newsGallery/{id}', [DeleteController::class, 'deleteNewsGallery']);
});

Route::prefix('social')->group(function () {
    Route::get('/messages', [SocialController::class, 'getMessages']);
    Route::get('/subscribers', [SocialController::class, 'getSubscribers']);
});

Route::prefix('imagesDB')->group(function () {
    Route::get('/', [ImageController::class, 'index']);
});

Route::prefix('multerUpload')->group(function () {
    Route::get('/', [UploadController::class, 'index']);
    Route::post('/newscover', [UploadController::class, 'uploadNewsCover']);
    Route::post('/company', [UploadController::class, 'uploadCompany']);
    Route::post('/management', [UploadController::class, 'uploadManagement']);
});

Route::get('/test', function () {
    return response()->json(['message' => 'This is an API test endpoint']);
});

Route::get('/mongo-test', function () {
    try {
        DB::connection('mongodb')->getMongoClient()->listDatabases();
        return response()->json(['message' => 'MongoDB connection successful']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});