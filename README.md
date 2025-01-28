# TODO API

A simple TODO API built with Symfony, powered by Docker, and leveraging FrankenPHP with Caddy for optimized performance.

## Getting Started

### Prerequisites

- [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
- [Symfony CLI](https://symfony.com/download) (optional, but useful for development)

### Installation & Setup

1. Clone the repository:
   ```sh
   git clone https://github.com/marek-d-lis/symfony-todo-api.git
   cd symfony-todo-api
   ```

2. Build the Docker images:
   ```sh
   docker compose build --no-cache
   ```

3. Start the application:
   ```sh
   docker compose up -d --wait
   ```

4. Open `https://localhost` in your browser and accept the auto-generated TLS certificate.

5. Stop the application when done:
   ```sh
   docker compose down --remove-orphans
   ```

## API Endpoints

The TODO API exposes the following endpoints:

### Tasks

- **Get a single task**: `GET /api/todos/{id}`
- **Get all tasks**: `GET /api/todos`
- **Create a task**: `POST /api/todos`
- **Update a task**: `PUT /api/todos/{id}`
- **Delete a task**: `DELETE /api/todos/{id}`

### Example Request

```sh
curl -X GET https://localhost/api/todos/1 -H "Accept: application/json"
```

## API Documentation

This project includes automatically generated API documentation using [NelmioApiDocBundle](https://symfony.com/bundles/NelmioApiDocBundle/current/index.html).

To view the API documentation, navigate to:
```
https://localhost/api/doc
```

## Features

- Fully containerized with Docker
- Automatic HTTPS (dev & prod)
- HTTP/3 and Early Hints support
- Symfony Messenger for CQRS pattern
- PostgreSQL as default database (easily switchable to MySQL)
- XDebug integration for debugging

## Development

1. Install dependencies:
   ```sh
   docker compose exec php composer install
   ```

2. Run database migrations:
   ```sh
   docker compose exec php bin/console doctrine:migrations:migrate
   ```

3. Run tests:
   ```sh
   docker compose exec php bin/phpunit
   ```

## Deployment

For production deployment, see [the official Symfony Docker documentation](https://github.com/dunglas/symfony-docker).

## License

This project is available under the MIT License.

## Contributors

Maintained by [Marek Lis](https://github.com/marek-d-lis).

