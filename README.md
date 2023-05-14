# Business trips

## How to deploy project
1. `cp backend/.env.example backend/.env`
2. `cp docker/.env.example docker/.env`
3. `cd docker/ && docker-compose up -d`
4. `docker-compose exec -u www-data php-fpm composer setup`

## End-points
- `POST` - `/employee/create` - create an employee.
- `GET` - `/trip/all?employee_id=` - get all trips for the employee.
- `POST` - `/trip/create` `{ "start": "Y-m-d H:i:s", "end": "Y-m-d H:i:s", "employee_id": 1, "country": "pl/de/gb" }` - create a trip for the employee.

## Project structure
- `app/Domain` - domain logic including entities, value objects, enums.
- `app/Application` - application logic including actions(controllers) and interacting logic.
- `app/Infrastrucure` - infrastructure logic including specific realizations (repositories, database types).
- `config/mappings` - database mappings for Doctrine ORM.
- `database/migrations` - migrations for database.
