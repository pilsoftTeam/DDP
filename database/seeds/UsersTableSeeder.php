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
        DB::table('usuarios')->insert([
            'name' => 'supervisor',
            'email' => 'supervisor@sistema.cl',
            'password' => bcrypt('supervisor')
        ]);

        DB::table('perfilamientos')->insert([
            'idPerfil' => 2,
            'idUsuario' => 2
        ]);
        DB::table('usuarios')->insert([
            'name' => 'revisor',
            'email' => 'revisor@sistema.cl',
            'password' => bcrypt('revisor')
        ]);

        DB::table('perfilamientos')->insert([
            'idPerfil' => 3,
            'idUsuario' => 3
        ]);


    }
}
