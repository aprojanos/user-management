# User Management - demo application

# Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Application Usage](#application-usage)
- [Seeding the database](#seeding-the-database)
- [Running Tests](#running-tests)    
- [Docker Installation](#docker-installation)    
- [Docker Compose Installation](#docker-compose-installation)

## Requirements

- **Docker and Docker Compose**

## Installation

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

### Set Environment Variables
In the .env file, you need to set the DB connection parameters and the admin user password to log in to the application for the first time.

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

Go to the project root directory, where is the docker-compose.yml file located and run the following command:

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

The application will run in the Laravel container named in our example: `user-management-laravel-1`.

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
### Exit the container and restart it
```bash
exit
docker compose restart laravel
```

### Start Vite server

```bash
docker exec -it {laravel_container_name} npm run dev
```
## Application Usage

The application consists of the following pages:

### Home

`Login`, `Register` functions, link to `Administration pages` for logged in users. 
Since no other content was specified, the home page contains a `map` showing the locations of users.

### Login

Generated at Laravel Breeze installation, slightly modified

The account created during the migration process for the `first login`:

```
e-mail: admin@example.com
password: {ADMIN_PASSWORD provided in .env}
```
### Register

Generated at Laravel Breeze installation, slightly modified

New users can register on this page. A confirmation email will be sent during the registration process. Emails are sent to the locally running **Mailpit** server - `.env` settings - which can be used to track emails via its web interface http://localhost:8025

The user can also log in without confirming his email address, but will not have access to the administration pages.

### Profile Settings

Generated at Laravel Breeze installation.

### Admin Dashboard

Home page of the administrative area. 
As no other content was specified, user-related charts were added here.

### User Management

This page contains the listing, uploading and modification of users as defined in the assesment.

## Seeding the database

Seeding the database with users and addresses:

```bash
docker exec -it {laravel_container_name} php artisan db:seed
```


## Running Tests

```bash
docker exec -it {laravel_container_name} php artisan test
```

This will execute all tests in the tests directory and provide a summary of test results.

## Docker Installation

- Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04

## Docker Compose Installation

Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-22-04
