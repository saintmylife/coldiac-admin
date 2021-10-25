<?php

Route::prefix('songlists')
    ->middleware('jwt.verify', 'permission:CRUD Songlist')
    ->name('songlists.')
    ->group(function () {
        Route::post('/', 'Create\SonglistCreateAction')->name('create');
        Route::put('/{id}', 'Edit\SonglistEditAction')->name('edit');
        Route::get('/', 'Index\SonglistIndexAction')->name('index');
        Route::get('/{id}', 'Fetch\SonglistFetchAction')->name('fetch');
        Route::delete('/{id}', 'Delete\SonglistDeleteAction')->name('delete');
        Route::put('order/{id}', 'Order\SonglistOrderAction')->name('order');
        Route::put('active/{id}', 'Active\SonglistActiveAction')->name('active');
    });
