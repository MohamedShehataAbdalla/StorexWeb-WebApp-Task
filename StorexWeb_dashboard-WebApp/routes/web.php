<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovieController;

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
    return view('auth.login');
});

Auth::routes();
Auth::routes(['register' => false]);


Route::middleware(['auth:web'])
    ->group(function (){

        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/home', [HomeController::class, 'index'])->name('home');




         Route::prefix('categories')->group(function () {


            Route::get('/', [CategoryController::class, 'index'])->name('categories');
            Route::get('/trash', [CategoryController::class, 'trash'])->withTrashed()->name('categories.trash');
            Route::get('/create', [CategoryController::class, 'create'])-> name('categories.create');
            Route::post('/store', [CategoryController::class, 'store'])-> name('categories.store');
            Route::get('/show/{id}', [CategoryController::class, 'show'])-> name('categories.show');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])-> name('categories.edit');
            Route::patch('/update', [CategoryController::class, 'update'])-> name('categories.update');
            Route::delete('/delete', [CategoryController::class, 'destroy'])-> name('categories.delete');
            Route::get('/softDelete/{id}', [CategoryController::class, 'softDelete'])-> name('categories.softDelete');
            Route::get('/restore/{id}', [CategoryController::class, 'restore'])-> name('categories.restore');

        });

        Route::prefix('movies')->group(function () {


            Route::get('/', [MovieController::class, 'index'])->name('movies');
            Route::get('/trash', [MovieController::class, 'trash'])->withTrashed()->name('movies.trash');
            Route::get('/create', [MovieController::class, 'create'])-> name('movies.create');
            Route::post('/store', [MovieController::class, 'store'])-> name('movies.store');
            Route::get('/show/{id}', [MovieController::class, 'show'])-> name('movies.show');
            Route::get('/edit/{id}', [MovieController::class, 'edit'])-> name('movies.edit');
            Route::patch('/update', [MovieController::class, 'update'])-> name('movies.update');
            Route::delete('/delete', [MovieController::class, 'destroy'])-> name('movies.delete');
            Route::get('/softDelete/{id}', [MovieController::class, 'softDelete'])-> name('movies.softDelete');
            Route::get('/restore/{id}', [MovieController::class, 'restore'])-> name('movies.restore');

        });





        Route::prefix('users')->group(function () {

            Route::resource('/', UserController::class);
            Route::get('/', [UserController::class, 'index'])->name('users');
            Route::get('/trash', [UserController::class, 'trash'])->withTrashed()->name('users.trash');
            Route::get('/create', [UserController::class, 'create'])-> name('users.create');
            Route::post('/store', [UserController::class, 'store'])-> name('users.store');
            Route::get('/show/{id}', [UserController::class, 'show'])-> name('users.show');
            Route::get('/edit/{id}', [UserController::class, 'edit'])-> name('users.edit');
            Route::patch('/update', [UserController::class, 'update'])-> name('users.update');
            Route::delete('/delete', [UserController::class, 'destroy'])-> name('users.delete');
            Route::get('/softDelete/{id}', [UserController::class, 'softDelete'])-> name('users.softDelete');
            Route::get('/restore/{id}', [UserController::class, 'restore'])-> name('users.restore');

        });



    });

