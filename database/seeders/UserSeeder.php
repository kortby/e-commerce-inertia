<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sa = \App\Models\User::factory()->create([
            'name' => 'Super-Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('l^zL3z&E1y84'),
            'phone' => rand(4151001000, 4159998888),
        ]);
        $sa->assignRole(1);

        $client = \App\Models\User::factory()->create([
            'name' => 'Client',
            'email' => 'client@example.com',
            'password' => Hash::make('azerty'),
            'phone' => rand(4151001000, 4159998888),
        ]);
        $client->assignRole(2);
    }
}
