<?php

use App\Admin;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('admins')->get()->count() == 0){

            $superAdmins = User::where('email', 'obura@tongoi.com')
                               ->orWhere('email', 'samihchege@gmail.com')
                               ->get();
            
            $superAdmins->each(function($user){
                Admin::create(array(
                    'user_id' => $user->id,
                    'is_super_admin' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                  ));
            });
  
            $this->command->info('Admins table seeded!');
  
          }
    }
}
