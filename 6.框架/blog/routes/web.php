<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    echo Swoole\Coroutine::getCid(), "<br/>";
    print_r(Swoole\Coroutine::stats());
    Swoole\Coroutine::sleep(10);
    echo "<br/>";
    echo getmypid(), "<br/>";
//    return view('welcome');
});

Route::get('/a', function () {
    echo "A请求：";
    echo Swoole\Coroutine::getCid(), "<br/>";
    print_r(Swoole\Coroutine::stats());
    echo "<br/>";
    echo getmypid(), "<br/>";
});

Route::get('/b', function () {
    echo "B请求：";
    echo Swoole\Coroutine::getCid(), "<br/>";
    print_r(Swoole\Coroutine::stats());
    echo "<br/>";
    echo getmypid(), "<br/>";
});
