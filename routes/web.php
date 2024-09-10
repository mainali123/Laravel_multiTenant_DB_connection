<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});
Route::post('/loginHandler', [\App\Http\Controllers\UserController::class, 'validate_user']);

Route::post('/companySelectedUser', [\App\Http\Controllers\CompanyController::class, 'company_selected_user']);

Route::get('/registerCompany', function () {
    return view('companyRegister');
});

Route::post('/registerCompanyHandler', [\App\Http\Controllers\CompanyController::class, 'register_company']);

Route::get('home', function () {
    dd(request());
});
