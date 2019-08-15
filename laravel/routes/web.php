<?php
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
});

Route::get('/get/dados', function () {
    #$urls = Illuminate\Support\Facades\DB::table('urls')->orderBy('id','desc')->limit(10)->pluck('url')->toArray();
    $emails = Illuminate\Support\Facades\DB::table('emails')->orderBy('id','desc')->limit(10)->pluck('email')->toArray();
    return response()
            ->json($emails);
});
