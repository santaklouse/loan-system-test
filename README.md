# Loan Issuance System - Test Assignment

## Install and Run

1. Clone the repository:
```bash
git clone https://github.com/santaklouse/loan-system-test
cd loan-system
```

2. Copy .env.example to .env:
```bash
cp .env.example .env
```

3. Build Docker containers:
```bash

4. Run containers:
```bash
make up
```

5. Install dependencies and run migrations:
```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

6. The application will be available at http://localhost:8080

## API Endpoints

### Clients
- `POST /api/clients` - Create a new client

### Loans
- `POST /api/loans/check` - Check the possibility of issuing a loan
- `POST /api/loans/issue` - Issue a loan

## Run tests

```bash
make test
```

## Make commands
- `make help` - Show this help
- `make build` - Build containers
- `make up` - Run containers
- `make down` - Stop containers
- `make restart` - Restart containers
- `make logs` - View logs
- `make shell` - Open a shell in the application container
- `make test` - Run tests
- `make lint` - Check code for standards compliance
- `make cs-fix` - Fix code style
