<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
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

/* @var Router $api */
$api = app(Router::class);
$api->version('v1', function ($api) {

    // authentication routes
    $api->post('login', [AuthController::class, 'login']);
    $api->post('register', [AuthController::class, 'register']);
    $api->post('logout', ['middleware' => 'api.auth', AuthController::class, 'logout']);

    // article routes
    $api->get('articles', [ArticleController::class, 'getArticles']);
    $api->get('articles/{articleId}', [ArticleController::class, 'getArticle']);
    $api->post('articles', [ArticleController::class, 'addArticle'])->middleware('role:super admin,admin');
    $api->put('articles/{articleId}', [ArticleController::class, 'editArticle'])->middleware('role:super admin,admin');
    $api->delete('articles/{articleId}', [ArticleController::class, 'deleteArticle'])->middleware('role:super admin');

    // comments routes
    $api->get('articles/{articleId}/comments', [CommentController::class, 'getComments']);
    $api->post('articles/{articleId}/comments', [CommentController::class, 'addComment'])->middleware('role:super admin,admin');
    $api->delete('articles/{articleId}/comments/{commentId}', [CommentController::class, 'deleteComment'])->middleware('role:super admin');
});


