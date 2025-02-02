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


Route::middleware(['web',  'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu'])->prefix('chartofaccounts')->group(function() {
    Route::get('/', 'ChartOfAccountsController@index');
    Route::get('/install', 'InstallController@index');
    Route::post('/install', 'InstallController@install');
    Route::get('/install/uninstall', 'InstallController@uninstall');
    Route::get('/install/update', 'InstallController@update');


    Route::get('/chart_view','ChartOfAccountsController@chart_view');
    Route::get('/addaccount/{account_id?}','ChartOfAccountsController@addacount');
    Route::post('/addaccount','ChartOfAccountsController@saveacount');
    Route::get('/getaccount','ChartOfAccountsController@getaccount');
    Route::get('/deleteaccount/{account_id?}','ChartOfAccountsController@deleteaccount');

    Route::get('/getaccountcode/{id}/{account_id?}','ChartOfAccountsController@getnextaccountcode');

    /* JournalController */




});

Route::middleware(['web',  'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu'])->prefix('journal')->group(function() {


    /*cash_receipt*/
    Route::get( '/get_cash_receipt','JournalController@get_cash_receipt');
    Route::get( '/cash_receipt','JournalController@cash_receipt');

    Route::get( '/cash_receipt_add','JournalController@cash_receipt_add');
    Route::get( '/cash_receipt_delete/{id}','JournalController@cash_receipt_delete');
    Route::post( '/cash_receipt_save','JournalController@cash_receipt_save');
    Route::get( '/get_account_type','JournalController@get_account_type');

    /* payment_receipt_add */
    Route::get( '/payment_receipt','JournalController@payment_receipt');
    Route::get( '/get_payment_receipt','JournalController@get_payment_receipt');
    Route::get( '/payment_receipt_add','JournalController@payment_receipt_add');
    Route::get( '/payment_receipt_delete/{id}','JournalController@payment_receipt_delete');
    Route::post( '/payment_receipt_save','JournalController@payment_receipt_save');


    Route::resource( '/','JournalController');
});
