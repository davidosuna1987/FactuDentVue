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
            'name' => 'David',
            'surnames' => 'Osuna Mondaca',
            'email' => 'davidosuna1987@gmail.com',
            'nif' => '39921344Z',
            'nickname' => 'davidosuna1987',
            'address' => 'C/ Bélciga 14, puerta 5',
            'locality' => 'València',
            'province' => 'Valencia',
            'country' => 'España',
            'post_code' => '46021',
            'password' => bcrypt('secret'),
            'role_id' => 1,
            'active' => true,
        ]);

        // factory(App\User::class)->create([
        //     'name' => 'Esther',
        //     'surnames' => 'Martínez Martínez',
        //     'email' => 'esthermaruiz@gmail.com',
        //     'nickname' => 'esthermaruiz',
        //     'password' => bcrypt('secret'),
        //     'api_key' => bcrypt('esthermaruiz@gmail.com'),
        //     'role_id' => 4,
        //     'active' => true,
        // ]);

        //Crear 3 usuarios user (ver ModelFactory.php)
        // factory(App\User::class, 3)->create();

        //Creamos 10 clínicas (ver ModelFactory.php)
        // factory(App\Clinic::class, 10)->create();
    }
}
