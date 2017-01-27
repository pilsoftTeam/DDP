<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OficinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regiones')->insert([
            'nombreRegion' => 'Arica y Parinacota'
        ]);
        DB::table('regiones')->insert([
            'nombreRegion' => 'Maule'
        ]);


        DB::table('comunas')->insert([
            'idRegion' => '1',
            'nombreComuna' => 'Arica'
        ]);
        DB::table('comunas')->insert([
            'idRegion' => '2',
            'nombreComuna' => 'Molina'
        ]);
        DB::table('comunas')->insert([
            'idRegion' => '2',
            'nombreComuna' => 'Talca'
        ]);
        DB::table('comunas')->insert([
            'idRegion' => '2',
            'nombreComuna' => 'San Javier'
        ]);


        DB::table('oficinas')->insert([
            'idComuna' => '1',
            'zona' => 'zona 1',
            'numeroLlamadoInterno' => 'N°21',
            'numeroZonaLicitacion' => '0',
            'direccion' => 'Arturo Gallo 294',
            'fono' => '(58) 2583040 - 2583041',
            'email' => 'arica@ddp.cl',
        ]);
        DB::table('oficinas')->insert([
            'idComuna' => '2',
            'zona' => 'zona 1',
            'numeroLlamadoInterno' => 'N°21',
            'numeroZonaLicitacion' => '1',
            'direccion' => 'Uno Norte 931, piso 7 , Oficina 704',
            'fono' => '(71) 2213055 - 2218282',
            'email' => 'maule@ddp.cl',
        ]);
        DB::table('oficinas')->insert([
            'idComuna' => '3',
            'zona' => 'zona 2',
            'numeroLlamadoInterno' => 'N°21',
            'numeroZonaLicitacion' => '1',
            'direccion' => 'Uno Norte 931, piso 7 , Oficina 704',
            'fono' => '(71) 2213055 - 2218282',
            'email' => 'maule@ddp.cl',
        ]);
        DB::table('oficinas')->insert([
            'idComuna' => '4',
            'zona' => 'zona 3',
            'numeroLlamadoInterno' => 'N°21',
            'numeroZonaLicitacion' => '1',
            'direccion' => 'Uno Norte 931, piso 7 , Oficina 704',
            'fono' => '(71) 2213055 - 2218282',
            'email' => 'maule@ddp.cl',
        ]);
    }
}
