# User Management - demo application

# Table of Contents

- [Minimum Requirements](#minimum-requirements)
- [Installation](#installation)
- [Running Tests](#running-tests)    
- [Docker Installation](#docker-installation)    
- [Docker Compose Installation](#docker-compose-installation)

## Minimum Requirements

- **Docker and Docker Compose**

## Installation

First, need a fresh installation of Docker and Docker Compose

### 1. Clone the Project

Clone the repository to your local machine:

```bash
git clone https://github.com/aprojanos/user-management.git
cd user-management
```

### 2. Copy Environment File

Copy the .env.example file to .env

```bash
cp .env.example .env
```

Copy the .env.testing.example file to .env.testing
```bash
cp .env.testing.example .env.testing
```

### 3. Set Environment Variables
In the .env file, you need to set the DB connections and some Host and Elasticsearch params.
Here is an example configuration:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=your_database_name # for example laravel
DB_USERNAME=your_database_username # for example sail
DB_PASSWORD=your_database_password # for example password

...

ADMIN_PASSWORD=the password for the created admin account (admin@example.com)
```

### 4. Build The Containers

Go to the project root directory, where is the docker-compose.yml file and add the following command:

```bash
docker-compose up -d --build
```

### 5. Install Dependencies:

Install PHP dependencies using Composer:

```bash
docker exec -it {php_fpm_container_name} composer install
```

or
```bash
docker exec -it {php_fpm_container_name} bash
composer install
```

### 6. Generate Application Key

```bash
docker exec -it {php_fpm_container_name} php artisan key:generate
```

or
```bash
docker exec -it {php_fpm_container_name} bash
php artisan key:generate
```


### 7. Run Migrations

Run the database migrations with seed:

```bash
docker exec -it {php_fpm_container_name} php artisan migrate:fresh
```

or

```bash
docker exec -it {php_fpm_container_name} bash
php artisan migrate:fresh
```

### 8. Install Npm Packages


```bash
docker exec -it {node_container_name} npm install
```

or

```bash
docker exec -it {node_container_name} npm install
```

## Running Tests

Run the tests:

```bash
php artisan test
```

or

```bash
docker exec -it {php_fpm_container} php artisan test
```


This will execute all tests in the tests directory and provide a summary of test results.

## Docker Installation

### Linux

- Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04

### Windows

- https://docs.docker.com/desktop/windows/install/

## Docker Compose Installation

### Linux

Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-22-04

### Windows
- Docker automatically installs Docker Compose.
