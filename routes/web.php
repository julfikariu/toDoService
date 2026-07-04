<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redis-test', function () {
    Redis::set('name', 'Julfikar');
    return Redis::get('name'); // স্ক্রিনে 'Julfikar' লেখা দেখালে কানেকশন ১০০% ওকে!
});
