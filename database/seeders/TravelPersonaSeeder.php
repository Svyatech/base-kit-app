<?php

namespace Database\Seeders;

use App\Models\Travel\Persona;
use Illuminate\Database\Seeder;

class TravelPersonaSeeder extends Seeder
{
    public function run(): void
    {
        Persona::upsert([
            ['slug' => 'first-time-asia', 'name' => 'Первый раз в Азии', 'description' => 'Нужны базовые объяснения и понятные инструкции'],
            ['slug' => 'with-kids', 'name' => 'С детьми', 'description' => 'Инфраструктура, медицина, еда, спокойные пляжи'],
            ['slug' => 'long-stay', 'name' => 'Зимовщик', 'description' => 'Жильё помесячно, визы, быт, бюджет на месяц'],
            ['slug' => 'budget', 'name' => 'Бюджетный', 'description' => 'Минимальные цены и способы сэкономить'],
            ['slug' => 'no-english', 'name' => 'Без английского', 'description' => 'Где есть русскоязычный сервис, а где нужен английский'],
            ['slug' => 'digital-nomad', 'name' => 'Цифровой кочевник', 'description' => 'Интернет, коворкинги, условия для работы'],
        ], ['slug'], ['name', 'description']);
    }
}
