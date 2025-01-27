<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the ADMIN_PASSWORD environment variable exists
        if (! env('ADMIN_PASSWORD')) {
            throw new \Exception('ADMIN_PASSWORD environment variable is not set.');
        }

        // Create the admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'status' => 'active',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove the admin user if it exists
        DB::table('users')->where('name', 'admin')->delete();
    }
}
