<?php


use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register',[AuthController::class, 'Register']);

Route::post('/login',[AuthController::class,'LogIn']);

Route::middleware(['auth'])->group(function () {
    Route::get('/LogOut', function () {
        $user = User::find(auth()->user()->id);
        $user->tokens()->delete();
        return response([
            "isSuccess"     =>      true,
            "msg"           =>      "Logged out"
        ],200);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
