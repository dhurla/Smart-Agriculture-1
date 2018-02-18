<?php

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

/*Route::get('/', function () {
    return view('index');
});*/

use Illuminate\Support\Facades\Input;
use App\Http\Middleware\Admin;
use App\Sale;
use App\User;
Route::get('/',function() {
    return view('home');
});

Route::get('/consumer',function() {
    return view('pages.consumer');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sell',function() {
    return view('farmer.sell');
});

/*Route::prefix('admin')->group(function() {
    Route::get('/profile', 'AdminController@index');
    Route::get('')
});*/
Route::group(['prefix'=>'admin','middleware'=>['auth','admin']],function() {
    Route::get('profile','AdminController@index');
    Route::get('users','AdminController@users');
    Route::get('users/deluser/{id}','AdminController@deluser');
    Route::get('sales','AdminController@sales');
    Route::get('reviews','AdminController@reviews');
});
  
Route::resource('sales','SalesController');

Route::resource('cart_items','CartController');

//Route::resource('admin','AdminController');

Route::get('profile/{id}','ProfileController@show');

Route::get('delitemfromcart','CartController@destory');

Route::any('/search',function() {
    $q = Input::get('q');
    $sales = Sale::where('name','LIKE','%'.$q.'%')->get();
    return view('consumers.index')->with('sales',$sales);
});

Route::get('/edit/{id}','SalesController@edit');

Route::get('/delete/{id}','SalesController@destroy');

Route::resource('review','ReviewController');

Route::get('/checkout','CartController@show');

Route::get('/government',function() {
    $farmers = User::where('type',2)->get();
    return view('government.farm_history')->with('farmers',$farmers);
});
/*
Route::get('admin/profile', ['middleware' => 'admin', function () {  
    return view('admin.profile');
}]);
*/