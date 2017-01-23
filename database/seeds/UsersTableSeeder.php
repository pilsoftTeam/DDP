<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'name' => 'Admin',
            'email' => 'admin@sistema.cl',
            'password' => bcrypt('admin')
        ]);

        DB::table('perfilamientos')->insert([
            'idPerfil' => 1,
            'idUsuario' => 1
        ]);


    }
}
