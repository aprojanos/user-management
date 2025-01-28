<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $answer = 'y';
        if (method_exists($this, 'command')) {
            $this->command->ask('Do you want to seed countries (Y/n)?', 'y');
        }
        if (strtolower($answer) == 'y') {
            $countries = [
                ['code' => 'SR', 'name' => 'Serbia'],
                ['code' => 'US', 'name' => 'United States'],
                ['code' => 'CA', 'name' => 'Canada'],
                ['code' => 'GB', 'name' => 'United Kingdom'],
                ['code' => 'AU', 'name' => 'Australia'],
                ['code' => 'DE', 'name' => 'Germany'],
                ['code' => 'FR', 'name' => 'France'],
                ['code' => 'IT', 'name' => 'Italy'],
                ['code' => 'ES', 'name' => 'Spain'],
                ['code' => 'JP', 'name' => 'Japan'],
                ['code' => 'CN', 'name' => 'China'],
                ['code' => 'IN', 'name' => 'India'],
                ['code' => 'BR', 'name' => 'Brazil'],
                ['code' => 'ZA', 'name' => 'South Africa'],
                ['code' => 'MX', 'name' => 'Mexico'],
                ['code' => 'RU', 'name' => 'Russia'],
                ['code' => 'SE', 'name' => 'Sweden'],
                ['code' => 'NO', 'name' => 'Norway'],
                ['code' => 'FI', 'name' => 'Finland'],
                ['code' => 'DK', 'name' => 'Denmark'],
                ['code' => 'NL', 'name' => 'Netherlands'],
                ['code' => 'BE', 'name' => 'Belgium'],
                ['code' => 'CH', 'name' => 'Switzerland'],
                ['code' => 'AT', 'name' => 'Austria'],
                ['code' => 'PL', 'name' => 'Poland'],
                ['code' => 'HU', 'name' => 'Hungary'],
                ['code' => 'CZ', 'name' => 'Czech Republic'],
                ['code' => 'PT', 'name' => 'Portugal'],
                ['code' => 'GR', 'name' => 'Greece'],
                ['code' => 'IE', 'name' => 'Ireland'],
                ['code' => 'NZ', 'name' => 'New Zealand'],
                ['code' => 'SG', 'name' => 'Singapore'],
                ['code' => 'MY', 'name' => 'Malaysia'],
                ['code' => 'TH', 'name' => 'Thailand'],
                ['code' => 'VN', 'name' => 'Vietnam'],
                ['code' => 'KR', 'name' => 'South Korea'],
                ['code' => 'AR', 'name' => 'Argentina'],
                ['code' => 'CL', 'name' => 'Chile'],
                ['code' => 'CO', 'name' => 'Colombia'],
                ['code' => 'SA', 'name' => 'Saudi Arabia'],
                ['code' => 'AE', 'name' => 'United Arab Emirates'],
                ['code' => 'EG', 'name' => 'Egypt'],
                ['code' => 'TR', 'name' => 'Turkey'],
                ['code' => 'PH', 'name' => 'Philippines'],
                ['code' => 'ID', 'name' => 'Indonesia'],
                ['code' => 'NG', 'name' => 'Nigeria'],
                ['code' => 'KE', 'name' => 'Kenya'],
                ['code' => 'GH', 'name' => 'Ghana'],
                ['code' => 'PK', 'name' => 'Pakistan'],
                ['code' => 'BD', 'name' => 'Bangladesh'],
            ];

            Country::upsert($countries, uniqueBy: ['code'], update: ['name']);
        }
    }
}
