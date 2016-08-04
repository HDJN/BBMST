<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'idx', 'uses' => 'Manage\ProductController@getList']);

# admin

# login
Route::post('/login/gologin', 'Manage\LoginController@getGologin'); 
Route::controller('login', 'Manage\LoginController');

# product
Route::post('/product/dealadd', 'Manage\ProductController@getDealadd');
Route::post('/product/dealedit', 'Manage\ProductController@getDealedit');
Route::post('/product/dealdel', 'Manage\ProductController@getDealdel');
Route::post('/product/dealrec', 'Manage\ProductController@getDealrec');
Route::post('/product/dealonline', 'Manage\ProductController@getDealonline');
Route::post('/product/dealoffline', 'Manage\ProductController@getDealoffline');
Route::post('/product/dealtop', 'Manage\ProductController@getDealtop');
Route::controller('product', 'Manage\ProductController');

# brand
Route::post('/brand/dealadd', 'Manage\BrandController@getDealadd');
Route::post('/brand/dealedit', 'Manage\BrandController@getDealedit');
Route::post('/brand/dealdel', 'Manage\BrandController@getDealdel');
Route::post('/brand/dealrec', 'Manage\BrandController@getDealrec');
Route::post('/brand/productbrand', 'Manage\BrandController@getProductbrand');
Route::controller('brand', 'Manage\BrandController');

# admin
Route::post('/editor/dealadd', 'Manage\EditorController@getDealadd');
Route::post('/editor/dealedit', 'Manage\EditorController@getDealedit');
Route::post('/editor/dealdel', 'Manage\EditorController@getDealdel');
Route::post('/editor/dealrec', 'Manage\EditorController@getDealrec');
Route::controller('editor', 'Manage\EditorController');

# upload
Route::post('/upload/uploadbrandimg', 'Manage\UploadController@getUploadbrandimg');
Route::post('/upload/uploadproductimg', 'Manage\UploadController@getUploadproductimg');
Route::post('/upload/uploadeditorimg', 'Manage\UploadController@getUploadeditorimg');


