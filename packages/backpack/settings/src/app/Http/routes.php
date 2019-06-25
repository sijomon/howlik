<?php

// Admin Interface Routes
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    // Settings
    CRUD::resource('setting', 'SettingCrudController');
});
