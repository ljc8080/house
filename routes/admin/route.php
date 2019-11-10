<?php
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::match(['get','post'],'login','LoginRegister@login')->name('adminlogin');
    Route::get('index','Index@index');
    Route::get('welcome','Index@welcome');
});