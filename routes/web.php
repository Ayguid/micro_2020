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

// Route::get('/', function () {
//   return view('welcome');
// });

Route::get('/', 'LandingController@index')->name('landing');


Auth::routes();

//grl stuff
Route::post('/send-mail', 'mailer\MailerController@sendMail')->name('sendIngMail');




/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
  //user
  Route::get('/country/{country_shortcode}', 'LandingController@setCountry')->name('setCountry');
  Route::get('/cats', 'LandingController@countryLanding')->name('countryLanding');
  Route::get('/cat/{id?}', 'LandingController@getCategoryData')->name('getCategoryData');
  Route::get('/prod/{id}', 'LandingController@showProduct')->name('showProduct');

  Route::get('/home', 'HomeController@index')->name('home');


  //search prod
  Route::get('/find/{q?}','LandingController@findProduct')->name('findProduct');

  //admin sections
  Route::prefix('admin')->group(function(){

//only superadmin & admin role
  Route::group(['middleware' => ['role_or_permission:superadmin|admin']], function () {
    Route::get('/cats', 'Admin\CategoryController@index')->name('admin.cats');
    Route::get('/cats/show/{id}', 'Admin\CategoryController@show')->name('admin.cats.show');
});





//only superadmin role
  Route::group(['middleware' => ['role_or_permission:superadmin']], function () {

    Route::post('/prods/store', 'Admin\ProductController@store')->name('admin.prods.store');
    Route::get('/prods/edit/{id}', 'Admin\ProductController@edit')->name('admin.prods.edit');
    Route::post('/prods/update/', 'Admin\ProductController@update')->name('admin.prods.update');


    Route::get('/cats/edit/{id}', 'Admin\CategoryController@edit')->name('admin.cats.edit');
    Route::post('/cats/update/{id}', 'Admin\CategoryController@update')->name('admin.cats.update');
    Route::post('/cats/store', 'Admin\CategoryController@store')->name('admin.cats.store');

    Route::post('/atts/add', 'Admin\AttributeController@addAttribute')->name('addAttribute');
    Route::get('/atts/edit/{id}', 'Admin\AttributeController@edit')->name('admin.atts.edit');
    Route::post('/atts/update/', 'Admin\AttributeController@update')->name('admin.atts.update');
    Route::delete('/atts/delete/{att}', 'Admin\AttributeController@destroy')->name('deleteAttribute');
    });


    Route::get('/users', 'Admin\UserController@index')->name('admin.users')->middleware('permission:index users');

    Route::group(['middleware' => ['role_or_permission:superadmin|admin|create users|edit users|delete users']], function () {
      Route::get('/users/create', 'Admin\UserController@create')->name('admin.users.create')->middleware('permission:create users');
      Route::post('/users/store', 'Admin\UserController@store')->name('admin.users.store')->middleware('permission:create users');
      Route::get('/users/show/{id}', 'Admin\UserController@show')->name('admin.users.show');
      Route::get('/users/edit/{id}', 'Admin\UserController@edit')->name('admin.users.edit')->middleware('permission:edit users');
      Route::post('/users/update/{id}', 'Admin\UserController@update')->name('admin.users.update')->middleware('permission:edit users');
      Route::post('/users/destroy/{id}', 'Admin\UserController@destroy')->name('admin.users.destroy')->middleware('permission:delete users');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|admin']], function () {
      Route::get('/roles', 'Admin\RoleController@index')->name('admin.roles');
      Route::get('/roles/show/{id}', 'Admin\RoleController@show')->name('admin.roles.show');
      Route::get('/roles/edit/{id}', 'Admin\RoleController@edit')->name('admin.roles.edit');
      Route::post('/roles/update/{id}', 'Admin\RoleController@update')->name('admin.roles.update');
    });


  });


});
