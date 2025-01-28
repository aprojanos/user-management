<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userCount = $this->command->ask('How many users do you want to create?', 10);

        if ($userCount > 0) {
        
            $addressCount = $this->command->ask('How many addresses per user?', 2);
            User::factory()
                ->hasAddresses($addressCount)
                ->count($userCount)
                ->create();
        }
    }
}

