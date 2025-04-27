<?php

use App\Jobs\LogEmail;
use App\Jobs\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    User::limit(10)->get()->each(function ($user) {
//        SendMail::dispatch($user);
        LogEmail::dispatch($user);
    });


    return view('welcome');
});
