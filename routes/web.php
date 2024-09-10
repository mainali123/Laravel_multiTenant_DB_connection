<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SwitchDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});
Route::post('/loginHandler', [UserController::class, 'validate_user']);

Route::group(['middleware' => [SwitchDatabase::class]], function () {
    Route::get('home', function () {
        print_r(session()->all());
        dd(DB::connection()->getDatabaseName());
    });

    Route::get('/viewDatas', function () {
        // Get the data from the database
        $data1 = DB::table('projects')->get();
        $data2 = DB::table('tasks')->get();
        $data3 = DB::table('departments')->get();
        $data4 = DB::table('employees')->get();

        dd($data1, $data2, $data3, $data4);
    });

    Route::post('/companySelectedUser', [CompanyController::class, 'company_selected_user']);

});


Route::get('/registerCompany', function () {
    return view('companyRegister');
});

Route::post('/registerCompanyHandler', [CompanyController::class, 'register_company']);


