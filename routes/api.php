<?php

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

Route::group(['prefix'=>'v1','namespace'=>'Api'],function(){
    Route::get('login','LoginController@login');
    Route::get('wxlogin','LoginController@wxlogin')->name('api.wxlogin');
    Route::post('wxlogin/update','LoginController@update')->name('api.wxlogin.update');
    Route::post('tenant/upload','TenantController@upload')->name('api.tenant.upload');
    Route::put('tenant/update','TenantController@update')->name('api.tenant.update');
    Route::get('tenant/edit','TenantController@edit')->name('api.tenant.edit');
    Route::get('appoint/list','AppointmentController@list')->name('api.appoint.list');
    Route::get('article/list','ArticleController@list')->name('api.article.list');
    Route::get('article/read','ArticleController@read')->name('api.article.read');
    Route::post('article/count','ArticleController@count')->name('api.article.count');
    Route::put('house/collect','HouseController@collect')->name('api.house.collect');
    Route::get('house/rem','HouseController@recommend')->name('api.house.rem');
    Route::get('housegroup','HouseAttrController@group')->name('api.housegroup');
    Route::get('attr','HouseAttrController@attr')->name('api.attr');
    Route::get('houseinfo','HouseController@houseinfo')->name('api.house.info');
    Route::get('house/iscollect','HouseController@is_collect')->name('api.house.iscollect');
    Route::get('collect/list','CollectController@list')->name('api.collect.list');
    Route::get('test','TestController@test')->middleware('checkapi');
});
