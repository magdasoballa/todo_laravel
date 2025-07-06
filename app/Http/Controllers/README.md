# Todo Laravel App

Aplikacja do zarządzania zadaniami (todo) napisana w Laravel.

## 🔧 Wymagania

- PHP 8.x
- Composer
- Laravel 10+
- Baza danych (MySQL / SQLite)
- Mailtrap (do testowania wysyłki e-maili)

## 🚀 Instalacja

1. Sklonuj repozytorium:


git clone https://github.com/magdasoballa/todo_laravel
cd todo-laravel

2. Zainstaluj zależności:
composer install

3. Skonfiguruj .env - ustaw dane dostępowe do bazy i maila (Mailtrap) w .env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=twoj_login
MAIL_PASSWORD=twoje_haslo
MAIL_FROM_ADDRESS=noreply@example.com

4.Uruchom migracje:
php artisan migrate

5.Uruchom lokalny serwer:
php artisan serve

6. Uruchom frontend:
npm run dev

