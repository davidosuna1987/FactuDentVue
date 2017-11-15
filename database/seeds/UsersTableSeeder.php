<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->truncate();

    	//Crear usuario administrador
        factory(App\User::class)->create([
            'name' => 'David Osuna',
            'email' => 'davidosuna1987@gmail.com',
            'username' => 'davidosuna1987',
            'password' => bcrypt('secret'),
            'api_key' => bcrypt('davidosuna1987@gmail.com'),
            'role_id' => 1, // 1 => god, 2 => admin, 3 => user
            'active' => true,
        ]);

        factory(App\User::class)->create([
            'name' => 'Carlos Faria',
            'email' => 'carlos@supermundano.com',
            'username' => 'supermundano',
            'password' => bcrypt('secret'),
            'api_key' => bcrypt('carlos@supermundano.com'),
            'role_id' => 2, // 1 => god, 2 => admin, 3 => user
            'active' => true,
        ]);

        $testing_client = factory(App\User::class)->create([
            'name' => 'Testing User',
            'email' => 'testing@user.com',
            'username' => 'testinguser',
            'password' => bcrypt('secret'),
            'api_key' => bcrypt('testing@user.com'),
            'role_id' => 3, // 1 => god, 2 => admin, 3 => user
            'active' => true,
        ]);

    	//Crear 2 usuarios user (ver ModelFactory.php)
        factory(App\User::class, 2)->create();
    }
}
