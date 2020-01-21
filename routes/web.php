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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/admin', 'HomeController@index')->name('home')->middleware('auth');


// main admin routes
Route::group([
  'prefix'=>'admin',
  'middleware'=>'auth',
  'namespace'=>'Admin',
  ],function(){

    // setting route
    Route::get('/setting','App\SettingController@index')->name('admin.setting');
    Route::post('/setting/{id}','App\SettingController@update')->name('admin.setting.update');
    //profile route
    Route::get('/profile','App\SettingController@profile')->name('admin.profile');
    Route::post('/profile','App\SettingController@post')->name('admin.profile.post');
    //For Admin Home Page Controll
    Route::get('/','Main\HomeController@index')->name('admin.home');

    // For Home Page change Theme
    Route::post('/theme/{name}','App\ThemeController@setTheme')->name('admin.theme');
    // Route group for loan
    Route::group([
      'prefix'=>'loan',
      'namespace'=>'Account'

    ],function(){
      // loan index show all loaner
      Route::get('/','LoanController@index')->name('admin.loan.index');
      // show unpaid customer
      Route::get('/unpaid','LoanController@unpaid')->name('admin.loan.unpaid');
      // loan create or register
      Route::get('register','LoanController@create')->name('admin.loan.create');
      // loan store to database
      Route::post('/','LoanController@store')->name('admin.loan.store');
      // loan show loaner
      Route::get('show/{id}','LoanController@show')->name('admin.loan.show');
      // view edit loans
      Route::get('/{id}/edit','LoanController@edit')->name('admin.loan.edit');
      // update loan account
      Route::put('update/{id}','LoanController@update')->name('admin.loan.update');

      // loan loan payment
      Route::get('payment/{id}','LoanPaymentController@payment')->name('admin.loan.payment');
      // update loan payment
      Route::put('payment/{id}','LoanPaymentController@update')->name('admin.loan.payment-update');
      // index of loan payment
      Route::get('payment','LoanPaymentController@index')->name('admin.loan.payment-index');
      // search loan account number
      Route::post('/search','LoanPaymentController@search')->name('admin.loan.payment-search');
      // update loan by search
      Route::put('/payment/update/{id}','LoanPaymentController@search_update')->name('admin.loan.payment-update.search');
      // for get Rate
      Route::get('rate/{id}','LoanController@getLoanRate')->name('admin.loan.rate');

    });
      // route group for deposit
      Route::group([
        'prefix'=>'deposit',
        'namespace'=>'Account'
      ],function(){
        Route::get('/','DepositController@index')->name('deposit.index');
        Route::get('/register','DepositController@create')->name('deposit.create');
        Route::post('/','DepositController@store')->name('deposit.post');
        // on index page
        Route::get('/detail/{id}','DepositController@detail')->name('deposit.detail');
        // add more saving
        Route::get('/add/{id}','DepositPayController@add')->name('deposit.add');
        Route::put('/add/{id}','DepositPayController@update')->name('deposit.add.update');
      });

      // route group for report
      Route::group([
        'prefix'=>'reports',
        'namespace'=>'Reports'
      ],function(){
        // route group for loan reports
        Route::get('/loans','LoanReportController@index')->name('reports.loan.index');
        Route::get('/loans/{id}/detail','LoanReportController@detail')->name('reports.loan.detail');
      });
});

// get Address route
Route::group([
  'prefix'=>'admin/address',
  'namespace'=>'Admin\Address',
  ],function(){
  Route::get('districts/{id}','AddressController@getDistricts')->name('address.districts');
  Route::get('communes/{id}','AddressController@getCommunes')->name('address.communes');
  Route::get('villages/{id}','AddressController@getVillages')->name('address.villages');
});
