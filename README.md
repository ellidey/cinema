# Cinema

Fullstack-приложение для сервиса продажи билетов в кино.

## Описание проекта

Cinema позволяет просматривать список фильмов, выбирать доступные киносеансы и
бронировать места в зале. Frontend отвечает за пользовательский интерфейс:
каталог фильмов, страницу фильма с сеансами, схему мест и модальное окно
бронирования. Backend предоставляет REST API для фильмов, залов, сеансов, мест и
броней.

Основные сущности:

- `Фильм`: название, изображение, описание, продолжительность;
- `Зал`: название и набор мест;
- `Киносеанс`: дата и время начала, фильм, зал;
- `Место`: название, ряд, номер в ряду, цена, зал;
- `Бронированное место`: дата брони, место, сеанс, стоимость, статус оплаты.

## Пояснительная записка

Проект разделен на два приложения:

- `backend` — Laravel API;
- `frontend` — React-приложение на TypeScript.

nginx выступает единой точкой входа на `80` порту: React доступен по
`http://localhost`, а Laravel API — по `http://localhost/api`. Такой вариант
приближен к production-схеме и не требует отдельного frontend-порта при запуске
через Docker.

PostgreSQL запускается отдельным контейнером. На хост-машину порт базы проброшен
как `55432`, чтобы не конфликтовать с локально установленным PostgreSQL на
стандартном порту `5432`.

Backend построен вокруг Laravel Resources. Валидация входящих данных находится в
Form Request-классах. Создание и оплата брони вынесены в actions. Повторяемые
фильтры, сортировки и загрузки связей вынесены в QueryBuilder-классы моделей,
чтобы контроллеры оставались тонкими.

Frontend хранит API-взаимодействие в `src/api`, страницы в `src/pages`,
переиспользуемые компоненты в `src/components`, стили — в `src/styles`.
Маршруты объявлены напрямую в `src/App.tsx`.

## Требования

- Docker Desktop
- Docker Compose
- Node.js и npm для локальной разработки frontend вне Docker
- PHP 8.3+ и Composer для локальной разработки backend вне Docker

## Стек

- Backend: Laravel, PHP-FPM
- Frontend: React, TypeScript, Axios, React Router, Vite, Remix Icon
- Инфраструктура: Docker Compose, nginx, PostgreSQL

## Структура проекта

```text
backend/              Laravel API
frontend/             React + TypeScript frontend
docker/               Конфигурация nginx и Docker-окружения
docker-compose.yml    Описание контейнеров приложения
```

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

Полезные команды внутри Docker:

```bash
docker compose exec backend php artisan migrate
docker compose exec backend php artisan db:seed
docker compose exec backend php artisan migrate:fresh --seed
docker compose exec backend php artisan test
docker compose exec backend php artisan route:list
```

Проверочный API:

```text
GET /api/health
```

Основные API-ресурсы:

```text
GET    /api/movies
GET    /api/movies/{movie}
GET    /api/halls
GET    /api/halls/{hall}
GET    /api/showtimes
GET    /api/showtimes/{showtime}
GET    /api/seats
GET    /api/seats/{seat}
GET    /api/reserved-seats
POST   /api/reserved-seats
GET    /api/reserved-seats/{reservedSeat}
PATCH  /api/reserved-seats/{reservedSeat}/pay
```

Поддерживаемые фильтры:

```text
GET /api/seats?hall_id=1
GET /api/reserved-seats?showtime_id=1
GET /api/reserved-seats?status=paid
GET /api/reserved-seats?status=unpaid
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
