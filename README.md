# Laravel Task Management API

This is a task management system for buildings, developed in Laravel 12 and fully containerized with Docker.

## Technologies Used

- Laravel 12
- PHP 8.2
- MySQL 8
- Redis
- NGINX
- Docker & Docker Compose
- PHPUnit for testing

## Installation and Setup
### Prerequisites
Before starting, ensure you have installed:
- Docker and Docker Compose
- Git

### Step 1: Clone the repository
```sh
git clone https://github.com/your-username/laravel-task-management.git
cd laravel-task-management
```

### Step 2: Configure the environment
Copy the `.env.example` file to `.env` and edit it as needed:
```sh
cp .env.example .env
```

### Step 3: Start the containers
```sh
docker-compose up -d
```

### Step 4: Install dependencies
```sh
docker exec -it laravel_app composer install
docker exec -it laravel_app php artisan key:generate
```

### Step 5: Create the database and run migrations
```sh
docker exec -it laravel_app php artisan migrate --seed
```

Your API is now ready.

## API Endpoints
The API follows a RESTful structure. All responses are in JSON format.

### Buildings

| Method | Endpoint               | Description                  |
|--------|------------------------|------------------------------|
| `GET`  | `/api/buildings`       | Lists all buildings         |
| `POST` | `/api/buildings`       | Creates a new building      |
| `GET`  | `/api/buildings/{id}`  | Retrieves a specific building |
| `PUT`  | `/api/buildings/{id}`  | Updates a building         |
| `DELETE` | `/api/buildings/{id}` | Deletes a building         |

#### Example `POST /api/buildings`
```json
{
  "name": "Burj Khalifa",
  "address": "Dubai"
}
```

### Tasks

| Method | Endpoint              | Description                   |
|--------|-----------------------|-------------------------------|
| `GET`  | `/api/tasks`          | Lists all tasks               |
| `POST` | `/api/tasks`          | Creates a new task            |
| `GET`  | `/api/tasks/{id}`     | Retrieves a specific task     |
| `PUT`  | `/api/tasks/{id}`     | Updates a task                |
| `DELETE` | `/api/tasks/{id}` | Deletes a task                |

#### Example `POST /api/tasks`
```json
{
  "title": "Fix elevator",
  "description": "Check and repair elevator system",
  "status": "Open",
  "assigned_user_id": 1,
  "building_id": 1
}
```

### Comments

| Method | Endpoint                               | Description                     |
|--------|---------------------------------------|---------------------------------|
| `GET`  | `/api/tasks/{taskId}/comments`       | Lists comments for a task      |
| `POST` | `/api/tasks/{taskId}/comments`       | Creates a new comment          |
| `GET`  | `/api/tasks/{taskId}/comments/{id}`  | Retrieves a specific comment   |
| `PUT`  | `/api/tasks/{taskId}/comments/{id}`  | Updates a comment              |
| `DELETE` | `/api/tasks/{taskId}/comments/{id}` | Deletes a comment              |

#### Example `POST /api/tasks/1/comments`
```json
{
  "user_id": 1,
  "content": "Started working on this"
}
```

## Automated Tests
To run the tests, execute:
```sh
docker exec -it laravel_app php artisan test
```

The tests cover:
- Creation, listing, updating, and deletion of Buildings.
- Creation and listing of Tasks.
- Creation, listing, updating, and deletion of Comments.

## Filters and Search Parameters
The `/api/tasks` endpoint supports the following filters:

| Parameter         | Type   | Example                   | Description                             |
|------------------|--------|--------------------------|-----------------------------------------|
| `status`        | string | `Open`, `In Progress`    | Filters by task status                 |
| `building_id`   | int    | `1`                      | Filters by associated building         |
| `assigned_user_id` | int | `2`                      | Filters by assigned user               |
| `start_date`    | date   | `2024-03-01`             | Filters tasks created after this date  |
| `end_date`      | date   | `2024-03-10`             | Filters tasks created before this date |

Example request with filters:
```sh
curl "http://localhost:8000/api/tasks?status=Open&start_date=2024-03-01&end_date=2024-03-10"
```

