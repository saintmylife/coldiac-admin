<?php

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', 'Login\AuthLoginAction')->name('login');
    Route::middleware('jwt.verify')->group(function () {
        Route::post('/change', 'Change\AuthChangeAction')->name('change');
        Route::get('/me', 'Profile\AuthProfileAction')->name('profile');
        Route::post('/logout', 'Logout\AuthLogoutAction')->name('logout');
    });
});
