<?php

Route::prefix('hero')
    ->middleware('jwt.verify', 'permission:CRUD Hero')
    ->name('hero.')
    ->group(function () {
        Route::post('/', 'Create\HeroCreateAction')->name('create');
        Route::put('/{id}', 'Edit\HeroEditAction')->name('edit');
        Route::get('/', 'Index\HeroIndexAction')->name('index');
        Route::get('/{id}', 'Fetch\HeroFetchAction')->name('fetch');
        Route::delete('/{id}', 'Delete\HeroDeleteAction')->name('delete');
        Route::put('active/{id}', 'Active\HeroActiveAction')->name('active');
    });
