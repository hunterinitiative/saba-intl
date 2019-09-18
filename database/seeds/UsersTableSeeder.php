<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // check if table is empty
        if(DB::table('users')->get()->count() == 0){

          User::create(array(
            'email' => 'obura@tongoi.com',
            'first_name' => 'Sammy',
            'last_name' => 'Tongoi',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ));

          User::create(array(
            'email' => 'samihchege@gmail.com',
            'first_name' => 'Sam',
            'last_name' => 'Chege',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ));

          $this->command->info('Users table seeded!');

        }
    }
}