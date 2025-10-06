Предварительные требования

Перед началом убедись, что у тебя установлено:

1. PHP 8.1+ (проверь: php -v)
2. Composer (проверь: composer --version)
3. Node.js 18+ (проверь: node -v)
4. npm (проверь: npm -v)
5. Git (проверь: git --version)
6. База данных (MySQL/PostgreSQL/SQLite)

Пошаговая инструкция развертывания

1. Клонирование репозитория

git clone https://github.com/Voldo123/dating-app.git  
cd dating-app

2. Настройка окружения

cp .env.example .env

Открываем .env для редактирования
НАСТРОЙ БАЗУ ДАННЫХ И ДРУГИЕ ПАРАМЕТРЫ:

В файле .env обязательно настрой:
APP_NAME=DatingApp
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dating_app
DB_USERNAME=root
DB_PASSWORD=

Или используй SQLite для простоты:
DB_CONNECTION=sqlite
(и закомментируй другие DB_ настройки)

3. Установка PHP зависимостей

Устанавливаем Composer пакеты
composer install

4. Генерация ключа приложения

php artisan key:generate

5. Настройка базы данных

Создаем базу данных (если используешь MySQL)
Сначала создай БД manually через phpMyAdmin или команду MySQL

Выполняем миграции
php artisan migrate

(Опционально) Заполняем тестовыми данными
php artisan db:seed

6. Установка Node.js зависимостей

Устанавливаем npm пакеты
npm install

7. Сборка фронтенда

Для разработки:
Запускает Vite dev server (горячая перезагрузка)
npm run dev

Для продакшена:
Собирает оптимизированную версию
npm run build

Запуск приложения

Способ 1: Разработка (рекомендуется)

Открой ДВА терминала:

Терминал 1 (фронтенд):
npm run dev
→ Vite запустится на http://localhost:5173

Терминал 2 (бэкенд):
php artisan serve
→ Laravel запустится на http://localhost:8000

Способ 2: Быстрый запуск

Сначала собери фронтенд
npm run build

Затем запусти сервер
php artisan serve
→ Приложение будет доступно на http://localhost:8000

Дополнительные команды (если нужно)

Очистка кэша Laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

Генерация storage link для файлов
php artisan storage:link

Запуск тестов
php artisan test

Решение возможных проблем

Если возникает ошибка с правами:
chmod -R 775 storage bootstrap/cache

Если не работает vite:
Переустанови зависимости
rm -rf node_modules
npm install
npm run dev

Если ошибка базы данных:
- Убедись, что БД создана
- Проверь настройки в .env
- Попробуй использовать SQLite для простоты

Проверка установки

После запуска открой в браузере:
- http://localhost:8000 - основное приложение
- http://localhost:5173 - Vite dev server (если запущен)
