<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\{
    Controller,
    LoginController,
    DashboardController,
    UsersController,
    ServicesController,
  
};

Route::get('/', function () {
    return view('home.index');
});

//Login
Route::get('/login', [LoginController::class, 'login'])->name('login');


// Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// Auth login
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

//registration
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/registerUser', [LoginController::class, 'registration'])->name('registration');

Route::get('/Verifieduser/{id}', [LoginController::class, 'verifyUser'])->name('Verifieduser');
Route::get('/forgotpassword', [LoginController::class, 'forgotPasswordPage'])->name('forgotpassword');
Route::post('/resetPassword', [LoginController::class, 'resetUserPassword'])->name('resetPassword');


Route::middleware(['auth'])->group(function () {


    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    //services
    Route::get('/services', [ServicesController::class, 'viewServices'])->name('services');
    Route::get('/get_services', [ServicesController::class, 'getAllServices'])->name('get_services');
    Route::post('/newService', [ServicesController::class, 'createService'])->name('newService');
    Route::post('/updateService', [ServicesController::class, 'updateServiceData'])->name('updateService');
    
    // Users
    Route::get('/changepassword', [UsersController::class, 'changePass'])->name('changepassword');
    Route::get('/doctor', [UsersController::class, 'viewDoctors'])->name('doctor');
    Route::get('/get_doctors', [UsersController::class, 'getAllDoctors'])->name('get_doctors');
    Route::post('/createDoctor', [UsersController::class, 'addDoctor'])->name('createDoctor');
    Route::post('/updateDoctor', [UsersController::class, 'updateDoctorData'])->name('updateDoctor');
    Route::post('/updatePass', [UsersController::class, 'updatePassword'])->name('updatePass');

    
     // Appointment
     Route::get('/appointment', [UsersController::class, 'viewAppointment'])->name('appointment');
     Route::get('/scheduleList', [UsersController::class, 'viewScheduledAppointment'])->name('scheduleList');
     Route::post('/createAppointment', [UsersController::class, 'createAppointmentSchedule'])->name('createAppointment');
     Route::post('/updateAppointment', [UsersController::class, 'updateAppointmentSchedule'])->name('updateAppointment');
     Route::get('/approveAppointment/{id}/{status}/{patient}', [UsersController::class, 'approveAppointmentSchedule'])->name('approveAppointment');
     Route::get('/monthlyAnalytics', [UsersController::class, 'getMonthlyAnalytics'])->name('monthlyAnalytics');
      
});
