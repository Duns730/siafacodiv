<?php

use Illuminate\Database\Seeder;

use App\User;
use Illuminate\Support\Facades\Hash;
//use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contraseña = "123456*a";
        $user = new User([
            "email" => "admin@duns730.com",
            "password" => Hash::make($contraseña),
            "name" => "ADMINISTRADOR",
        ]);
        $user->saveOrFail();

        $user->assignRole('super.admin');


    }
}
