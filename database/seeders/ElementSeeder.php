<?php

namespace Database\Seeders;

use App\Models\Element;
use Illuminate\Database\Seeder;

class ElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $elements = [
            ['name' => 'logo'],
            ['name' => 'números'],
            ['name' => 'apellidos'],
            ['name' => 'bordado'],
            ['name' => 'impresión'],
        ];
        foreach ($elements as $element) {
            Element::create($element);
        }
    }
}
