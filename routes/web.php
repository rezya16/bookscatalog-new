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



Route::get('author','AuthorsController@index');
Route::get('book','BooksController@index');
Route::post('addbook','BooksController@store');
Route::post('addauthor','AuthorsController@store');
Route::post('editauthor','AuthorsController@update');
Route::post('editbook','BooksController@update');
Route::post('deleteauthor','AuthorsController@destroy');
Route::post('deletebook','BooksController@destroy');
Route::get('searchauthor','AuthorsController@searchAuthor');
Route::get('searchbook','BooksController@searchBook');



