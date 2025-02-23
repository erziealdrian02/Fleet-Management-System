<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\GPSTrackerController;
use App\Http\Controllers\TripsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {  
    Route::get('/dashboard', [DashboardController::class, 'index'])  
        ->name('dashboard'); 
    
    // Vehicle Controller
    Route::get('/vehicle', [VehicleController::class, 'index'])  
        ->name('vehicle'); 
    Route::post('/vehicle/store', [VehicleController::class, 'store'])  
        ->name('vehicle.store');
    Route::put('/vehicle/update/{id}', [VehicleController::class, 'update'])  
        ->name('vehicle.update');
    Route::delete('/vehicle/delete/{id}', [VehicleController::class, 'delete'])  
        ->name('vehicle.delete');  

    // Driver Controller
    Route::get('/driver', [DriverController::class, 'index'])  
        ->name('driver'); 
    Route::post('/driver/store', [DriverController::class, 'store'])  
        ->name('driver.store');
    Route::put('/driver/update/{id}', [DriverController::class, 'update'])  
        ->name('driver.update');
    Route::delete('/driver/delete/{id}', [DriverController::class, 'delete'])  
        ->name('driver.delete');  

    // Tracking Controller
    Route::get('/tracking', [GPSTrackerController::class, 'index'])  
        ->name('tracking'); 
    Route::get('/tracking/form-add', [GPSTrackerController::class, 'formAdd'])  
        ->name('tracking.from-add');
    Route::post('/tracking/store', [GPSTrackerController::class, 'store'])  
        ->name('tracking.store');
    Route::get('/tracking/form-edit/{id}', [GPSTrackerController::class, 'formEdit'])  
        ->name('tracking.from-edit');
    Route::post('/tracking/update/{id}', [GPSTrackerController::class, 'update'])  
        ->name('tracking.update');
    Route::delete('/tracking/delete/{id}', [GPSTrackerController::class, 'delete'])  
        ->name('tracking.delete');  

    Route::get('/company', [CompanyController::class, 'index'])  
        ->name('company'); 
    Route::get('/company/form-add', [CompanyController::class, 'formAdd'])  
        ->name('company.from-add');
    Route::post('/company/store', [CompanyController::class, 'store'])  
        ->name('company.store');
    Route::get('/company/form-edit/{id}', [CompanyController::class, 'formEdit'])  
        ->name('company.from-edit');
    Route::post('/company/update/{id}', [CompanyController::class, 'update'])  
        ->name('company.update');
    Route::delete('/company/delete/{id}', [CompanyController::class, 'delete'])  
        ->name('company.delete');  

    Route::get('/trips', [TripsController::class, 'index'])  
        ->name('trips'); 
    Route::get('/trips/form-add', [TripsController::class, 'formAdd'])  
        ->name('trips.from-add');
    Route::post('/trips/store', [TripsController::class, 'store'])  
        ->name('trips.store');
    Route::get('/trips/form-edit/{id}', [TripsController::class, 'formEdit'])  
        ->name('trips.from-edit');
    Route::post('/trips/update/{id}', [TripsController::class, 'update'])  
        ->name('trips.update');
    Route::delete('/trips/delete/{id}', [TripsController::class, 'delete'])  
        ->name('trips.delete');  
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
