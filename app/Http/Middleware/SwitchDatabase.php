<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;

class SwitchDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->has('company')) {
            $companyId = $request->input('company');

            // Find the company database based on the provided company ID
            $company_db = Company::where('id', $companyId)->pluck('company_db')->first();

            session(['company_db' => $company_db]);

            if ($company_db) {
                // Configure the new database connection
                Config::set('database.connections.dynamic', [
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
                ]);

                // Clear the cache and set the default connection
                Artisan::call('config:clear');
                DB::setDefaultConnection('dynamic');
            }
        } else if (session()->has('company_db')) {
            Config::set('database.connections.dynamic', [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3308'),
                'database' => 'company_' . session('company_db'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', 'Admin123###'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]);
            Artisan::call('config:clear');
            DB::setDefaultConnection('dynamic');
        }
        return $next($request);
    }
}
