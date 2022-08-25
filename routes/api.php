<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

// put all api protected routes here
Route::middleware('auth:api')->group(function () {
    //User
    Route::get('user-details', [UserController::class, 'userDetails']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::apiResources([
        'categories' => CategoryController::class,
        'products' => ProductController::class,
    ]);




// Verb	     URI	        Action	           Route Name
// GET	   /photos	       index	         photos.index     http://127.0.0.1:8000/api/categories
// GET  	/photos/create	create	         photos.create
// POST	    /photos     	store	          photos.store    http://127.0.0.1:8000/api/categories
// GET	/photos/{photo}    	show           	photos.show
// GET	/photos/{photo}/edit	edit	   photos.edit
// PUT/PATCH	/photos/{photo}	update	   photos.update
// DELETE	/photos/{photo}	   destroy	  photos.destroy



});
