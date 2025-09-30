<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем админа
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@vstrechka.ru',
            'password' => Hash::make('admin123'),
            'age' => 30,
            'gender' => 'Мужчина',
            'city' => 'Москва',
            'about' => 'Администратор сайта знакомств Vstrechka',
            'telegram' => 'admin_vstrechka',
            'role' => 'admin',
        ]);

        // Массивы для рандомных данных
        $maleNames = ['Александр', 'Дмитрий', 'Максим', 'Сергей', 'Андрей', 'Алексей'];
        $femaleNames = ['Анна', 'Мария', 'Екатерина', 'Ольга', 'Наталья', 'Ирина'];
        $cities = ['Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань', 'Нижний Новгород'];
        $aboutTexts = [
            'Люблю активный отдых и путешествия. Ищу серьезные отношения.',
            'Работаю в IT, увлекаюсь фотографией. Хочу встретить интересного человека.',
            'Люблю кино, музыку и вкусную еду. Ищу того, с кем можно разделить увлечения.',
            'Спортивный, целеустремленный. Ищу девушку для серьезных отношений.',
            'Творческая личность, занимаюсь рисованием. Ищу вдохновение в людях.',
            'Люблю природу и животных. Ищу доброго и отзывчивого человека.',
        ];

        // Создаем 3 мужских профиля
        for ($i = 0; $i < 3; $i++) {
            User::create([
                'name' => $maleNames[$i],
                'email' => 'user' . ($i + 1) . '@vstrechka.ru',
                'password' => Hash::make('password123'),
                'age' => rand(22, 35),
                'gender' => 'Мужчина',
                'city' => $cities[array_rand($cities)],
                'about' => $aboutTexts[$i],
                'telegram' => 'user' . ($i + 1),
                'role' => 'user',
            ]);
        }

        // Создаем 3 женских профиля
        for ($i = 0; $i < 3; $i++) {
            User::create([
                'name' => $femaleNames[$i],
                'email' => 'user' . ($i + 4) . '@vstrechka.ru',
                'password' => Hash::make('password123'),
                'age' => rand(20, 32),
                'gender' => 'Женщина',
                'city' => $cities[array_rand($cities)],
                'about' => $aboutTexts[$i + 3],
                'telegram' => 'user' . ($i + 4),
                'role' => 'user',
            ]);
        }

        $this->command->info('✅ Создан администратор: admin@vstrechka.ru / admin123');
        $this->command->info('✅ Создано 6 тестовых пользователей: user1@vstrechka.ru - user6@vstrechka.ru / password123');
    }
}