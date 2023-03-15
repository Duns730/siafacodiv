<?php

use Illuminate\Database\Seeder;

use App\State;

class StatesSeeder extends Seeder
{
    protected $states = [
        ['name' => 'AMAZONAS'],
        ['name' => 'ANZOATEGUI'],
        ['name' => 'APURE'],
        ['name' => 'ARAGUA'],
        ['name' => 'BARINAS'],
        ['name' => 'BOLIVAR'],
        ['name' => 'CARABOBO'],
        ['name' => 'COJEDES'],
        ['name' => 'DISTRITO CAPITAL'],
        ['name' => 'FALCON'],
        ['name' => 'GUARICO'],
        ['name' => 'LARA'],
        ['name' => 'MERIDA'],
        ['name' => 'MIRANDA'],
        ['name' => 'MONAGAS'],
        ['name' => 'NUEVA ESPARTA'],
        ['name' => 'PORTUGUESA'],
        ['name' => 'SUCRE'],
        ['name' => 'TACHIRA'],
        ['name' => 'TRUJILLO'],
        ['name' => 'VARGAS'],
        ['name' => 'YARACUY'],
        ['name' => 'ZULIA'],
        ['name' => 'DELTA AMACURO']
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->states as $state) {
            State::create($state);
        }
    }
}
