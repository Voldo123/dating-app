<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Начинаем транзакцию для безопасного выполнения
        DB::beginTransaction();

        try {
            // Сначала создаем теги
            $tags = [
                'Путешествия',
                'Кино', 
                'Музыка',
                'Спорт',
                'ИТ',
                'Искусство',
                'Кулинария', 
                'Фотография',
                'Книги',
                'Природа'
            ];

            $tagModels = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagModels[] = $tag;
            }

            $this->command->info('✅ Создано/проверено 10 тегов');

            // Создаем админа
            $admin = User::firstOrCreate(
                ['email' => 'admin@vstrechka.ru'],
                [
                    'name' => 'Администратор',
                    'password' => Hash::make('admin123'),
                    'age' => 30,
                    'gender' => 'Мужчина',
                    'city' => 'Москва',
                    'about' => 'Администратор сайта знакомств Vstrechka',
                    'telegram' => 'admin_vstrechka',
                    'role' => 'admin',
                ]
            );

            // Добавляем теги админу (3 случайных тега)
            $adminTags = collect($tagModels)->random(3)->pluck('id')->toArray();
            $admin->tags()->sync($adminTags);

            $this->command->info('✅ Создан/проверен администратор с тегами');

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

            // Предопределенные наборы тегов для разных типов пользователей
            $tagCombinations = [
                [0, 1, 2],   // Путешествия, Кино, Музыка
                [3, 4, 5],   // Спорт, ИТ, Искусство  
                [6, 7, 8],   // Кулинария, Фотография, Книги
                [0, 3, 9],   // Путешествия, Спорт, Природа
                [1, 4, 7],   // Кино, ИТ, Фотография
                [2, 5, 8],   // Музыка, Искусство, Книги
                [0, 6, 9],   // Путешествия, Кулинария, Природа
                [3, 7, 8],   // Спорт, Фотография, Книги
            ];

            // Создаем 3 мужских профиля
            for ($i = 0; $i < 3; $i++) {
                $user = User::firstOrCreate(
                    ['email' => 'user' . ($i + 1) . '@vstrechka.ru'],
                    [
                        'name' => $maleNames[$i],
                        'password' => Hash::make('password123'),
                        'age' => rand(22, 35),
                        'gender' => 'Мужчина',
                        'city' => $cities[array_rand($cities)],
                        'about' => $aboutTexts[$i],
                        'telegram' => 'user' . ($i + 1),
                        'role' => 'user',
                    ]
                );

                // Добавляем теги пользователю (3 случайных тега)
                $userTags = $tagCombinations[$i % count($tagCombinations)];
                $tagIds = collect($tagModels)->filter(function($tag, $index) use ($userTags) {
                    return in_array($index, $userTags);
                })->pluck('id')->toArray();
                
                $user->tags()->sync($tagIds);
            }

            // Создаем 3 женских профиля
            for ($i = 0; $i < 3; $i++) {
                $user = User::firstOrCreate(
                    ['email' => 'user' . ($i + 4) . '@vstrechka.ru'],
                    [
                        'name' => $femaleNames[$i],
                        'password' => Hash::make('password123'),
                        'age' => rand(20, 32),
                        'gender' => 'Женщина',
                        'city' => $cities[array_rand($cities)],
                        'about' => $aboutTexts[$i + 3],
                        'telegram' => 'user' . ($i + 4),
                        'role' => 'user',
                    ]
                );

                // Добавляем теги пользователю (3 случайных тега)
                $userTags = $tagCombinations[($i + 3) % count($tagCombinations)];
                $tagIds = collect($tagModels)->filter(function($tag, $index) use ($userTags) {
                    return in_array($index, $userTags);
                })->pluck('id')->toArray();
                
                $user->tags()->sync($tagIds);
            }

            DB::commit();
            
            $this->command->info('✅ Создано 6 тестовых пользователей с тегами: user1@vstrechka.ru - user6@vstrechka.ru / password123');
            $this->command->info('🎉 Все данные успешно созданы!');

        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('❌ Ошибка при создании данных: ' . $e->getMessage());
            throw $e;
        }
    }
}