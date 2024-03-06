<?php

use App\Http\Controllers\ProjectsController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('projects', ProjectsController::class); 
});

Route::post('/sanctum/token', function(Request $request){
    
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);    

    $user = User::where('email', $request->email)->first();

    
    
    if(!$user || !Hash::check($request->password, $user->password)){
        return response()->json(['error' => 'Not matched']);
    }

    return $user->createToken($request->device_name)->plainTextToken;

});