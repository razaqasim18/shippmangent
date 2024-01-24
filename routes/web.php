<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['verify' => true]);

Route::group(["middleware" => ['verified', 'auth:web']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // profile
    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
        Route::post('/update', [App\Http\Controllers\HomeController::class, 'profileUpdate'])->name('update');
        Route::post('/picture/update', [App\Http\Controllers\HomeController::class, 'profilePictureupdate'])->name('picture.update');
        Route::get('/picture/remove', [App\Http\Controllers\HomeController::class, 'profilePictureremove'])->name('picture.remove');
        Route::post('/password/update', [App\Http\Controllers\HomeController::class, 'profilePasswordupdate'])->name('password.update');
    });

    //Ship
    Route::prefix('/ship')->name('ship.')->group(function () {
        Route::get('/add', [App\Http\Controllers\ShipController::class, 'add'])->name('add');
        Route::post('/insert', [App\Http\Controllers\ShipController::class, 'insert'])->name('insert');
        Route::middleware('ristricteditor')->group(function () {
            Route::get('/', [App\Http\Controllers\ShipController::class, 'index'])->name('list');
            Route::get('/edit/{id}', [App\Http\Controllers\ShipController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [App\Http\Controllers\ShipController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\ShipController::class, 'delete'])->name('delete');
        });
    });

    //crew
    Route::prefix('/crew')->name('crew.')->group(function () {
        Route::get('/add', [App\Http\Controllers\CrewController::class, 'add'])->name('add');
        Route::post('/insert', [App\Http\Controllers\CrewController::class, 'insert'])->name('insert');
        Route::middleware('ristricteditor')->group(function () {

            Route::get('/', [App\Http\Controllers\CrewController::class, 'index'])->name('list');
            Route::get('/edit/{id}', [App\Http\Controllers\CrewController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [App\Http\Controllers\CrewController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\CrewController::class, 'delete'])->name('delete');

            // salary
            Route::prefix('/salary')->name('salary.')->group(function () {
                Route::get('/{id}', [App\Http\Controllers\CrewController::class, 'loadSalary'])->name('load');
                Route::post('/insert', [App\Http\Controllers\CrewController::class, 'salarySubmit'])->name('insert.submit');
            });
        });
    });
});

Route::prefix('/crews')->name('crews.')->group(function () {

    Route::get('/password/reset', [App\Http\Controllers\Crew\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Crew\Auth\ForgotPasswordController::class, 'sendCrewResetLinkEmail'])->name('password.email');

    Route::get('/password/reset/{token}', [App\Http\Controllers\Crew\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [App\Http\Controllers\Crew\Auth\ResetPasswordController::class, 'reset'])->name('password.update');


    Route::get('/login', [App\Http\Controllers\Crew\Auth\LoginController::class, 'showCrewLoginForm'])->name('login.view');
    Route::post('/login', [App\Http\Controllers\Crew\Auth\LoginController::class, 'crewLogin'])->name('login.submit');

    // logout
    Route::post('/logout', [App\Http\Controllers\Crew\Auth\LoginController::class, 'crewLogout'])->name('logout');


    Route::group(["middleware" => ['verified', 'auth:crew']], function () {
        Route::get('/', [App\Http\Controllers\Crew\HomeController::class, 'index']);
        Route::get('/home', [App\Http\Controllers\Crew\HomeController::class, 'index'])->name('home');
        Route::get('/dashboard', [App\Http\Controllers\Crew\HomeController::class, 'index'])->name('dashboard');

        // profile
        Route::prefix('/profile')->name('profile.')->group(function () {
            Route::get('/', [App\Http\Controllers\Crew\HomeController::class, 'profile'])->name('profile');
            Route::post('/update', [App\Http\Controllers\Crew\HomeController::class, 'profileUpdate'])->name('update');
            Route::post('/picture/update', [App\Http\Controllers\Crew\HomeController::class, 'profilePictureupdate'])->name('picture.update');
            Route::get('/picture/remove', [App\Http\Controllers\Crew\HomeController::class, 'profilePictureremove'])->name('picture.remove');
            Route::post('/password/update', [App\Http\Controllers\Crew\HomeController::class, 'profilePasswordupdate'])->name('password.update');
        });
    });
});
