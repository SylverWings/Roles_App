<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return "Bienvenidos";
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(
    ['middleware'=> 'jwt.auth'],
    function(){
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    }
);

Route::group(
    ['middleware'=> ['jwt.auth', 'isSuperAdmin']],
    function(){
        Route::get('/users/{id}', [UserController::class, 'getUserById']);
        Route::post('/users/{id}', [UserController::class, 'addRoleSuperAdminToUserById']);
        Route::delete('/users/{id}', [UserController::class, 'deleteUserById']);
    }
);

Route::group(
    ['middleware'=> 'jwt.auth'],
    function(){
        Route::get('/tasks', [TaskController::class, 'getAllTasks']);
        Route::post('/tasks', [TaskController::class, 'createTasks']);
        Route::put('/tasks', [Taskontroller::class, 'updateTasks']);
        Route::delete('/tasks', [TaskController::class, 'deleteTasks']);
    }
);