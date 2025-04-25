<?php

use App\Jobs\LogEmail;
use App\Jobs\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $lock = Cache::lock('foo', 60);
    if ($lock->get()) {
        User::limit(1)->get()->each(function($user) {
            SendMail::dispatch($user);
            LogEmail::dispatch($user);
        });
//        $lock->release();
    }

    return view('welcome');
});
