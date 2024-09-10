<?php

namespace App\Models;

use App\Helpers\EnvUpdater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'subdomain',
        'company_db'
    ];

    public function create_company($data): array
    {
        $company_db = rand(100000, 999999);

        $company = Company::where('name', $data['name'])->where('subdomain', $data['domain'])->get();

        if ($company->count() > 0) {
            $finalResponse = ['success' => false, 'message' => 'Company already exists'];
        } else {
            while (Company::where('company_db', $company_db)->exists()) {
                $company_db = rand(100000, 999999);
            }


            // Insert values into the database
            $company = new Company();
            $company->name = $data['name'];
            $company->subdomain = $data['domain'];
            $company->company_db = $company_db;
            $company->save();

            DB::statement('CREATE DATABASE ' . "company_$company_db");

            config(['database.connections.company_' . $company_db => [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3308'),
                'database' => 'company_' . $company_db,
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', 'Admin123###'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]]);
            Artisan::call('config:clear');
            Artisan::call('migrate', ['--database' => 'company_' . $company_db]);

            $finalResponse = ['success' => true, 'message' => 'Company created successfully'];
        }
        return $finalResponse;
    }

    public function select_company_db($data): JsonResponse
    {
        $company_db = Company::where('id', $data['company'])->pluck('company_db')->first();

        if ($company_db) {
            // Register the new database connection dynamically
            config(['database.connections.company_' . $company_db => [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3308'),
                'database' => 'company_' . $company_db,
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', 'Admin123###'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]]);

            Artisan::call('config:clear');

            DB::setDefaultConnection('company_' . $company_db);

            $currentDatabase = DB::connection()->getDatabaseName();

            return response()->json(['success' => true, 'message' => 'Company selected successfully', 'database' => $currentDatabase]);
        } else {
            return response()->json(['success' => false, 'message' => 'Company not found']);
        }
    }
}
