<?php

use App\Jobs\LogEmail;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    User::limit(1)->get()->each(function ($user) {
        LogEmail::dispatch($user);
    });

    return view('welcome');
});
