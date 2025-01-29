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

### Clone the Project

Clone the repository to your local machine:

```bash
git clone https://github.com/aprojanos/user-management.git
cd user-management
```

### Copy Environment File

Copy the .env.example file to .env

```bash
cp .env.example .env
```

Copy the .env.testing.example file to .env.testing
```bash
cp .env.testing.example .env.testing
```

### Set Environment Variables
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

### Build the Containers

Go to the project root directory, where is the docker-compose.yml file and add the following command:

```bash
docker compose up -d --build
```
Example output:
```
 ✔ laravel.test                                  Built                                                                                                                              0.0s 
 ✔ Network user-management_network           Created                                                                                                                            0.1s 
 ✔ Volume "user-management_mysql"            Created                                                                                                                            0.0s 
 ✔ Container user-management-mailpit-1       Started                                                                                                                            0.4s 
 ✔ Container user-management-mysql-1         Started                                                                                                                            0.3s 
 ✔ Container user-management-laravel-1  Started                                                                                                                            0.6s 

```

The application will run in the Laravel container from our example it's name is `user-management-laravel-1`.

### Enter the container
```bash
docker exec -it {laravel_container_name} bash
```

### Install Dependencies:

```bash
composer install
```

### Generate Application Key

```bash
php artisan key:generate
```


### Run Migrations

Run the database migrations with seed:

```bash
php artisan migrate:fresh
```

### Link Storage to public folder

```bash
php artisan storage:link
```
### Make web user the owner of the storage

```bash
chown sail:sail storage -R
```

### Install Npm Packages

```bash
npm install
```

### Start Vite server

```bash
npm run dev
```

## Running Tests

### Enter the container

```bash
docker exec -it {laravel_container_name} bash
```
### Run the tests

```bash
php artisan test
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
