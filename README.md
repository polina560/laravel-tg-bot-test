# Laravel 12 Backend Template

Шаблон для быстрого старта разработки бэкенд-приложений на Laravel 12.

## Требования к ПО

Для работы с проектом необходимо:

- **PHP 8.3** или новее
- **Node.js 20** или новее
- **MySQL 8.0** или новее

---

## Настройка OpenServer

Для запуска проекта на OpenServer выполните следующие шаги:

1. Переименуйте папку `.osp.example` в `.osp`.
2. В файлах `.osp/project.ini`, `.osp/tasks.ini` и в имени файла `.osp/Nginx/domain.loc.conf` замените `domain.loc` на нужный вам домен.
3. Включите модули Nginx и PHP-FCGI в настройках OpenServer.
4. Перезапустите OpenServer, чтобы изменения вступили в силу.

---

## Установка и запуск проекта

### 1. Клонирование репозитория

```
git clone [URL репозитория]
cd [название папки проекта]
```

### 2. Установка PHP зависимостей

```shell
composer install
```

### 3. Установка JavaScript зависимостей

```shell
npm install
```

### 4. Настройка окружения

- Скопируйте файл `.env.example` в `.env`
- Настройте параметры базы данных в `.env`
- Сгенерируйте ключ приложения:
```shell
php artisan key:generate
```

### 5. Запуск миграций

```shell
php artisan migrate
```

### 6. Создание администратора Moonshine

```shell
php artisan moonshine:user
```

## Локальный запуск проекта

1. Запуск Laravel-сервера:
   ```shell
   php artisan serve
   ```

2. Запуск среды разработки Vite:
   ```shell
   npm run dev
   ```

3. Админ панель Moonshine будет доступна по адресу:
   ```
   http://localhost:8000/admin
   ```

### Полезные команды

- Сборка фронтенда для production:
```shell
npm run build
```

- Запуск линтеров:
```shell
npm run lint
```

- Форматирование кода:
```shell
npm run format
```