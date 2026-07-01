# Cinema

Fullstack-приложение для сервиса продажи билетов в кино.

## Требования

- Docker Desktop
- Docker Compose
- Node.js и npm для локальной разработки frontend вне Docker
- PHP 8.3+ и Composer для локальной разработки backend вне Docker

## Стек

- Backend: Laravel, PHP-FPM
- Frontend: React, TypeScript, Axios, React Router, Vite
- Инфраструктура: Docker Compose, nginx, PostgreSQL

## Запуск через Docker

```bash
docker compose up --build
```

После запуска доступны:

```text
Frontend: http://localhost
API:      http://localhost/api
Health:   http://localhost/api/health
DB:       localhost:55432
```

Порт PostgreSQL на хосте изменен на `55432`, чтобы не конфликтовать с локальной
установкой PostgreSQL на стандартном порту `5432`.

## Переменные базы данных

Внутри Docker backend подключается к PostgreSQL так:

```text
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=cinema
DB_USERNAME=cinema
DB_PASSWORD=cinema
```

Для подключения к базе с хост-машины используйте:

```text
HOST=localhost
PORT=55432
DATABASE=cinema
USER=cinema
PASSWORD=cinema
```

## Маршрутизация nginx

nginx слушает порт `80`:

- `/` и frontend-маршруты отдаются из собранного React-приложения;
- `/api/*` передается в Laravel через PHP-FPM.

## Backend

Команды выполнять из директории `backend`.

```bash
composer install
php artisan test
php artisan route:list
```

Проверочный API:

```text
GET /api/health
```

## Frontend

Команды выполнять из директории `frontend`.

```bash
npm install
npm run build
```

Для локальной разработки вне Docker:

```bash
npm run dev
```

## Docker-команды

```bash
docker compose up --build
docker compose up -d
docker compose down
docker compose logs -f
docker compose build backend
docker compose build nginx
```
