<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/siproblem');

Route::get('/siproblem/test', function () {
    $user = auth()->user();

    \Filament\Notifications\Notification::make()
        ->title('Sending Test Notification')
        ->sendToDatabase($user);
    dd($user);
})->middleware('auth');
