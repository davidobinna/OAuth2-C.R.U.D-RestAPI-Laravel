<?php

//use App\Models\Article;
use App\Http\Controllers\CommentController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
   return $request->user();
});




Route::resource('comment', 'CommentController')->only([
   'index','show'
]);

Route::resource('comment','CommentController')->only([
   'store','update','destroy'
])->middleware('auth:api');

Route::group(['middleware' => ['cors', 'json.response']],function(){
      //public Authentication routes

      Route::post('/login','Auth\ApiAuthController@login')->name('login.api');

      Route::post('/register','Auth\ApiAuthController@register')->name('resgister.api');

      Route::post('/emailpassword','Auth\ApiForgetPasswordController@sendResetLinkEmail')->name('emailpass.api');
});


Route::get('/password/reset/{token}', 'Auth\ApiResetPasswordController@showResetForm');

Route::middleware('auth:api')->group(function(){
   Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');                 
});
/***
 * GET REQUEST
 * curl http://127.0.0.1:8000/api/comment/4 -i
 * 
 * DELETE REQUEST
 *  curl -X DELETE http://127.0.0.1:8000/api/comment/5 -i
 * 
 * POST REQUEST
 *  curl -X POST -H 'Content-Type: application/json' -d '{
    "name": "Holly",
    "text": "You are the best programmer in history !"
}' http://127.0.0.1:8000/api/comment/ -i
 * 
 * 
 * UPDATE REQUEST 
 *  curl -X PUT -H 'Content-Type: application/json' -d '{
  "name": "Holly",
  "text": "My updated comment"
}'http://127.0.0.1:8000/api/comment/4 -i
 */
