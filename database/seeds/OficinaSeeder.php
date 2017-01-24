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
        DB::table('oficinas')->insert([
            'zona' => 'zona1',
            'numeroLlamadoInterno' => 'N°21',
            'numeroZonaLicitacion' => '0',
            'region' => 'Arica y Parinacota',
            'comuna' => 'Arica',
            'direccion' => 'Arturo Gallo 294',
            'fono' => '(58) 2583040 - 2583041',
            'email' => 'arica@ddp.cl',
            'estado' => 'pendiente'
        ]);
        DB::table('oficinas')->insert([
            'zona' => 'zona1',
            'numeroLlamadoInterno' => 'N°21',
            'numeroZonaLicitacion' => '1',
            'region' => 'Maule',
            'comuna' => 'Molina',
            'direccion' => 'Uno Norte 931, piso 7 , Oficina 704',
            'fono' => '(71) 2213055 - 2218282',
            'email' => 'maule@ddp.cl',
            'estado' => 'pendiente'
        ]);
    }
}
