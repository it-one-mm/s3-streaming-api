<?php


use App\Http\Controllers\Api\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {
    Route::delete('videos/delete', [VideoController::class, 'destroy']);
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact itonemm@gmail.com'
    ], 404);
});



