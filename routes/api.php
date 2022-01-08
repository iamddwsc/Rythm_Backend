<?php

use App\Http\Controllers\treeChiasenhac;
use App\Scraper\ChartsVN;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Auth route // not used
Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
Route::get('logout', 'Api\AuthController@logout');

//Home
Route::get('slider', 'Api\HomeController@getSlider');
Route::get('new-album-2020-vn', 'Api\HomeController@getNewAlbum2020_vn');
Route::get('new-album-2020-usuk', 'Api\HomeController@getNewAlbum2020_usuk');
Route::get('new-album-2020-kr', 'Api\HomeController@getNewAlbum2020_kr');
Route::get('new-album-2020-cn', 'Api\HomeController@getNewAlbum2020_cn');
Route::get('new-album-2020-jp', 'Api\HomeController@getNewAlbum2020_jp');
Route::get('new-album-2020-other', 'Api\HomeController@getNewAlbum2020_other');

//Song & play
Route::post('album', 'Api\AlbumsController@getAlbum');
Route::post('lyric', 'Api\SongsController@getLyric');
//Chart
Route::post('chart', 'Api\ChartController@getChart');
//Search
Route::post('search', 'Api\SearchController@getSearch');
Route::post('search-by-song', 'Api\SearchController@getSearchSong');

// chiasenhac tree
Route::get('/test', [TreeChiasenhac::class, 'test']);

Route::get('/test2', [TreeChiasenhac::class, 'scrape']);
