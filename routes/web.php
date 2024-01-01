<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogcommentController;
use App\Models\Blog;
use App\Models\Article;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\WorkFlowController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	$blogs = Blog::latest()->get();
	$articles = Article::where('status',4)->latest('published_at')->get();
    return view('frontend.index',compact('blogs','articles'));
});

require __DIR__.'/auth.php';

Route::group(['prefix' => 'blog','middleware' => 'auth'], function(){
	Route::get('/show',[BlogController::class, 'Blogweb'])->name('blog');
	Route::post('/store',[BlogController::class, 'BlogStore'])->name('blog.store');
	Route::get('/edit/{id}',[BlogController::class, 'BlogEdit'])->name('blog.edit');
	Route::post('/update',[BlogController::class, 'BlogUpdateWeb'])->name('blog.update');
	Route::get('/delete/{id}',[BlogController::class, 'BlogDeleteWeb'])->name('blog.delete');
	Route::get('/comments/show',[BlogcommentController::class, 'BlogCommentsWeb'])->name('blog.comment');
	Route::get('/comments/approve/{id}',[BlogcommentController::class, 'BlogCommentsApprove'])->name('blog.approve');
});


Route::group(['prefix' => 'article','middleware' => 'auth'], function(){
	Route::get('/show',[ArticleController::class, 'Articleweb'])->name('article');
	Route::get('/edit/{id}',[ArticleController::class, 'ArticleEdit'])->name('article.edit');
	Route::get('/delete/{id}',[ArticleController::class, 'ArticleDelete'])->name('article.delete');
	Route::get('/user/show',[ArticleController::class, 'UserArticle'])->name('auth.article');
	Route::get('/publish/show',[ArticleController::class, 'PublishedArticle'])->name('publish.article');
});

Route::group(['prefix' => 'workflows','middleware' => 'auth'], function(){
	Route::get('/',[WorkFlowController::class, 'workflows'])->name('workflows');
	Route::get('/user/activate/{id}',[WorkFlowController::class, 'UserActivate'])->name('user.activate');
	Route::get('/article/publish/{id}',[WorkFlowController::class, 'ArticlePublish'])->name('article.publish');
});


///frontend routes
Route::get('/post/{id}/{title}',[FrontendController::class,'BlogPage']);
Route::post('/comments/post',[FrontendController::class,'CommentSubmit'])->name('submit.comment');
Route::get('/article/{id}/{title}',[FrontendController::class,'ArticlePage']);
