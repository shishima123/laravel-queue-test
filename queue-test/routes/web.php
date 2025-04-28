<?php

use App\Jobs\LogEmail;
use App\Jobs\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    User::limit(1)->get()->each(function ($user) {
        SendMail::dispatch($user);
        LogEmail::dispatch($user->toArray());
    });


    return view('welcome');
});
