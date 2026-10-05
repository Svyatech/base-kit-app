<?php

namespace Database\Seeders;

use App\Models\Travel\Persona;
use Illuminate\Database\Seeder;

class TravelPersonaSeeder extends Seeder
{
    public function run(): void
    {
        $personas = [
            ['first-time-asia', 'Первый раз в Азии', 'Нужны базовые объяснения и понятные инструкции'],
            ['with-kids', 'С детьми', 'Инфраструктура, медицина, еда, спокойные пляжи'],
            ['long-stay', 'Зимовщик', 'Жильё помесячно, визы, быт, бюджет на месяц'],
            ['budget', 'Бюджетный', 'Минимальные цены и способы сэкономить'],
            ['no-english', 'Без английского', 'Где есть русскоязычный сервис, а где нужен английский'],
            ['digital-nomad', 'Цифровой кочевник', 'Интернет, коворкинги, условия для работы'],
        ];

        Persona::upsert(
            array_map(fn (array $p): array => [
                'slug' => $p[0],
                'name' => json_encode(['ru' => $p[1]], JSON_UNESCAPED_UNICODE),
                'description' => json_encode(['ru' => $p[2]], JSON_UNESCAPED_UNICODE),
            ], $personas),
            ['slug'],
            ['name', 'description'],
        );
    }
}
