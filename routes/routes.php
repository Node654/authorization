<?php


use Auth\Controllers\HomeControllers;
use Auth\Controllers\UserControllers;
use Auth\Route\Route;



Route::get('/^\/$/', [HomeControllers::class, 'index']);
Route::get('/^\/register$/', [UserControllers::class, 'showRegisterForm']);
Route::get('/^\/login$/', [UserControllers::class, 'showLoginForm']);
Route::get('/^\/logout$/', [UserControllers::class, 'logout']);
Route::post('/^\/login$/', [UserControllers::class, 'login']);
Route::post('/^\/register$/', [UserControllers::class, 'register']);
Route::get('/^\/profile\/(\d+)$/', [UserControllers::class, 'show']);
Route::get('/^\/update\/(\d+)$/', [UserControllers::class, 'update']);
Route::post('/^\/update$/', [UserControllers::class, 'edit']);



