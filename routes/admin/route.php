<?php
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::match(['get', 'post'], 'login', 'LoginRegister@login')->name('adminlogin');
    Route::middleware(['checklogin:30'])->group(function () {
        Route::get('index', 'Index@index');
    });
    Route::get('welcome', 'Index@welcome');
    Route::get('logout', 'LoginRegister@logout')->name('adminlogout');
});


