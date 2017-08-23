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
    return view('errors.503');
});

Route::get('/', function () {
    return view('welcome')->with('name','KangJinYoung'); // 그닥인 방법
});

Route::get('/',function (){
    return view('welcome',[
        'name' => 'KangJinYoung',
        'greeting' => 'Nice to meet you'
    ]);
}); // 실전방식

Route::get('/blade',function (){
    $items = ['apple','bae','watermelon'];
    return view('blade',[
        'name' => 'KangJinYoung',
        'greeting' => 'Nice to meet you',
        'items' => $items
    ]);
});

Route::resource('articles','ArticlesController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
