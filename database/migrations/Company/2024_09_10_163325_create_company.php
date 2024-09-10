<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subdomain');
            $table->string('company_db');
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->timestamps();
        });

        // Insert random sample data
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            DB::table('company')->insert([
                'name' => $faker->company,
                'subdomain' => $faker->domainWord,
                'company_db' => $faker->domainWord . '_db',
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            DB::table('employees')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'company_id' => $faker->numberBetween(1, 5),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            DB::table('departments')->insert([
                'name' => $faker->word,
                'company_id' => $faker->numberBetween(1, 5),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            DB::table('projects')->insert([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'company_id' => $faker->numberBetween(1, 5),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            DB::table('tasks')->insert([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'project_id' => $faker->numberBetween(1, 5),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('company');
    }
};
