<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // User::factory(400000)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            ]);*/
        /*
            $this->call(DatabaseSeeder::class);
DB::disableQueryLog();

        $users = [];
        $total = 20;
        $chunk = 20;

        for ($i = 1; $i <= $total; $i++) {
            $users[] = [
                'id' => rand(10000000,99999999),
                'user_name' => rand(10000000,99999999),
                'email' => fake()->unique()->safeEmail(),
                'password' => 5,
            ];

            if (count($users) === $chunk) {
                User::insert($users);
                $users = [];
            }
        }

        // في حالة باقي records
        if (!empty($users)) {
            User::insert($users);
        }
*/



        $admin = User::create([
            'id' => 1,
            'name' => 'a',
            'user_name' => 'a',
            'email' => 'a@g',
            'password' => Hash::make('aaaaaaaa'),
            'balance' => 1000.00,
        ]);

        $adminRole = role::create([
            'id' => 1,
            'name' => 'admin'
        ]);

        $admin->roles()->attach($adminRole->id);

    }
}
