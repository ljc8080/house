<?php
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::match(['get', 'post'], 'login', 'LoginRegisterController@login')->name('adminlogin');
    Route::middleware(['checklogin', 'checkauth'])->group(function () {
        Route::get('index', 'IndexController@index')->name('admin');
        Route::get('welcome', 'IndexController@welcome')->name('admin.welcome');
        Route::get('logout', 'LoginRegisterController@logout')->name('adminlogout');
        Route::get('manager', 'ManagerController@list')->name('admin.manager');
        Route::match(['get', 'post'], 'manager/add', 'ManagerController@add')->name('manageradd');
        Route::match(['get', 'post'], 'manager/me', 'ManagerController@me')->name('managerme');
        Route::get('manager/read/{id}', 'ManagerController@read')->name('manageredit');
        Route::put('manager/edit/{id}', 'ManagerController@edit')->name('manager.dealedit');
        Route::delete('manager/del/{id}', 'ManagerController@delete')->name('manager.delete');
        Route::delete('manager/delall', 'ManagerController@deleteAll')->name('manager.delall');
        Route::put('manager/recovery/{id}', 'ManagerController@recovery')->name('manager.rec');
        Route::get('houseown/excel', 'HouseOwnController@excel')->name('hown.excel');
        Route::post('article/upload', 'HouseOwnController@upload')->name('hown.upload');
        Route::post('hown/upload', 'ArticleController@upload')->name('article.upload');
        Route::delete('article/unlink', 'ArticleController@unlink')->name('article.unlink');
        Route::get('house.city', 'HouseController@getcity')->name('house.city');
        Route::resource('role', 'RoleController');
        Route::resource('rule', 'RuleController');
        Route::resource('article', 'ArticleController');
        Route::resource('hattr', 'HouseAttrController');
        Route::resource('hown', 'HouseOwnController');
        Route::resource('house', 'HouseController');
        Route::resource('test', 'TestController');
        Route::post('upload', 'BaseController@upload')->name('admin.upload');
        Route::resource('appoint', 'AppointmentController');
        Route::resource('tenant', 'TenantController');
        Route::resource('apilogin', 'ApiLoginController');
    });
});


