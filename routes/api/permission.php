<?php

Route::prefix('permissions')->middleware('jwt.auth', 'role:super-admin')->name('permission.')->group(function () {
    Route::get('/', 'Index\PermissionIndexAction')->name('index');
    // Route::post('/', 'Create\PermissionCreateAction')->name('create');
    // Route::get('/{id}', 'Fetch\PermissionFetchAction')->name('fetch');
    // Route::put('/{id}', 'Edit\PermissionEditAction')->name('edit');
    // Route::delete('/{id}', 'Delete\PermissionDeleteAction')->name('delete');
});
