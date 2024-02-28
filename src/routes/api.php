<?php

use App\Http\Controllers\ArticleController;
use Dingo\Api\Routing\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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


/*Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
}); */

/* @var Router $api */
$api = app(Router::class);
$api->version('v1', function ($api) {
    $api->post('login', [AuthController::class, 'login']);
    $api->post('register', [AuthController::class, 'register']);
    $api->post('logout', ['middleware' => 'api.auth', AuthController::class, 'logout']);

    $api->get('articles', [ArticleController::class, 'getArticles']);
    $api->post('articles', [ArticleController::class, 'addArticle'])->middleware('role:super admin,admin');
    $api->put('articles/{articleId}', [ArticleController::class, 'editArticle'])->middleware('role:super admin,admin');
    $api->delete('articles/{articleId}', [ArticleController::class, 'deleteArticle'])->middleware('role:super admin');
});


