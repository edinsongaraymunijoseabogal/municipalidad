<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('organizational_units')->insert([
            ['name' => 'Gerencia'],
            ['name' => 'Administración'],
            ['name' => 'Recursos Humanos'],
            ['name' => 'Contabilidad'],
            ['name' => 'Tesorería'],
            ['name' => 'Informática'],
            ['name' => 'Comunicaciones'],
            ['name' => 'Secretaría'],
            ['name' => 'Alcaldía'],
        ]);

        DB::table('positions')->insert([
            ['name' => 'Gerente', 'organizational_unit_id' => 1],
            ['name' => 'Jefe de Administración', 'organizational_unit_id' => 2],
            ['name' => 'Jefe de Recursos Humanos', 'organizational_unit_id' => 3],
            ['name' => 'Contador', 'organizational_unit_id' => 4],
            ['name' => 'Tesorero', 'organizational_unit_id' => 5],
            ['name' => 'Jefe de Informática', 'organizational_unit_id' => 6],
            ['name' => 'Jefe de Comunicaciones', 'organizational_unit_id' => 7],
            ['name' => 'Secretario', 'organizational_unit_id' => 8],
            ['name' => 'Alcalde', 'organizational_unit_id' => 9],
        ]);

        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'alcaldia@municjosesabogal.com',
            'password' => Hash::make('MUNI@2024'),
            'role' => 'admin',
            'status' => true,
            'organizational_unit_id' => 6,
            'position_id' => 6,
            'central_phone' => null,
            'extension' => null,
            'photo' => null,
        ]);
    }
}
