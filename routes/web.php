<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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
Route::middleware(['ws_auth'])->group(function () {

    Route::get('/','HomeController@home');
    Route::get('/pricing','HomeController@pricing');
    Route::get('/plans','HomeController@plans');

    
});

Route::get('/faq','HomeController@faq');
Route::get('/testimonials','HomeController@testimonials');

Route::get('/features','HomeController@features');
Route::get('/terms','HomeController@terms');
Route::get('/privacy','HomeController@privacy');
Route::get('/about','HomeController@about');

Route::get('/home', function () {
    $request = URL::getRequest();
    return redirect('/');
});
Route::get('/pricing.php', function () {
    $request = URL::getRequest();
    $url = str_replace('pricing.php', 'pricing', $request->getRequestUri());
    return redirect($url);
});
Route::get('/testimonials.php', function () {
    $request = URL::getRequest();
    $url = str_replace('testimonials.php', 'testimonials', $request->getRequestUri());
    return redirect($url);
});
Route::get('/contactUs.php', function () {
    $request = URL::getRequest();
    $url = str_replace('contactUs.php', 'contact', $request->getRequestUri());
    return redirect($url);
});
Route::get('/aboutUs.php', function () {
    $request = URL::getRequest();
    $url = str_replace('aboutUs.php', 'about', $request->getRequestUri());
    return redirect($url);
});

// - https://help.webstarts.com/search?query=links
Route::get('/help/{keyword1}/{keyword2?}', function ($keyword1, $keyword2='') {
    $request = URL::getRequest();

    $keyword = $keyword1;

    if(!empty($keyword2)) {
        $keyword2 = str_replace('.php', '', $keyword2);

        $keyword = $keyword2;
    }

    $keyword = str_replace('-', '+', $keyword);

    return Redirect::away('https://help.webstarts.com/search?query='.$keyword, 301);
});


Route::fallback(function ($page) {
    $request = URL::getRequest();
    //$url = 'https://manage.webstarts.com'.$request->getRequestUri();
    $url = env('WS_URL').$request->getRequestUri();
    
    //dd($request);

    if($request->method() == 'GET') {
        return Redirect::away($url, 307);
    } else if($request->method() == 'OPTIONS') {
        return Redirect::away($url, 301);
    } else if($request->method() == 'POST') {
        return Route::post($url);
    }
});
