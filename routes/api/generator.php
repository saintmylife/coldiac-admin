<?php

Route::prefix('generators')
    ->name('generators.')
    ->group(function () {
        Route::get('/', 'Index\GeneratorIndexAction')->middleware('jwt.verify')->name('create');
        Route::post('/', 'Create\GeneratorCreateAction')->name('create');
    });
