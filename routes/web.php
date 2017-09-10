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



Route::get('/', 'HomeController@index')->name('home');
/*
DB::listen(function ($query){
    dump($query);
});*/

Route::get('/info',function (){
    return phpinfo();
});


Route::get('/mail',function (){
    $article = \App\Article::with('user')->find(1);
    return Mail::send(
        'emails.articles.created',
        compact('article'),
        function ($message) use ($article){
            $message -> to('siaer00@naver.com');
            $message -> subject('메일 전송 테스트');
        }
    );
});

Route::resource('articles','ArticlesController');

////////////////////////////////////////////////////////////////////////////////


/* 사용자 가입 */

Route::get('auth/register', [
    'as' => 'users.create',
    'uses' => 'UsersController@create'
]);

Route::post('auth/register',[
    'as' => 'users.store',
    'uses' => 'UsersController@store'
]);

Route::get('auth/confirm/{code}',[
    'as' => 'users.confirm',
    'uses' => 'UsersController@confirm'
])->where('code','[\pL-\pN]{60}');

/* 사용자 인증 */

Route::get('auth/login',[
    'as' => 'sessions.create',
    'uses' => 'SessionsController@create'
]);

Route::post('auth/login',[
    'as' => 'sessions.store',
    'uses' => 'SessionsController@store'
]);

Route::get('auth/logout',[
    'as' => 'sessions.destroy',
    'uses' => 'SessionsController@destroy'
]);

/* 비밀번호 초기화 */

Route::get('auth/remind',[
    'as' => 'remind.create',
    'uses' => 'PasswordsController@getRemind'
]);

Route::post('auth/remind',[
   'as' => 'remind.store',
   'uses' => 'PasswordsController@postRemind'
]);

Route::get('auth/reset/{token}',[
    'as' => 'reset.create',
    'uses' => 'PasswordsController@getReset'
])->where('token','[\pL-\pN]{64}');

Route::post('auth/reset',[
    'as' => 'reset.store',
    'uses' => 'PasswordsController@postReset'
]);

/* Social Login*/

Route::get('social/{provider}',[
    'as' => 'social.login',
    'uses' => 'SocialController@execute',
]);


/* 태그 */

Route::get('tags/{slug}/articles',[
    'as' => 'tags.articles.index',
    'uses' => 'ArticlesController@index',
]);