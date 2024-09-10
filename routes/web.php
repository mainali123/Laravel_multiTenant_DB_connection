<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});
Route::post('/loginHandler', [UserController::class, 'validate_user']);

Route::post('/companySelectedUser', [CompanyController::class, 'company_selected_user']);

Route::get('/registerCompany', function () {
    return view('companyRegister');
});

Route::post('/registerCompanyHandler', [CompanyController::class, 'register_company']);

Route::get('home', function () {
    dd(request());
});
