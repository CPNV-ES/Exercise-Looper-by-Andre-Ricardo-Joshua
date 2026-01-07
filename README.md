# Exercise-Looper-by-Andre-Ricardo-Joshua
MAW1.1 - Exercise Looper by Andre Ricardo Joshua

## Description

This website is designed to create and manage exercises form.
The main features are :
- Create an exercise form
- Manage an existing exercise form
- Take an existing exercise

## Getting Started

### Prerequisites

* PHP version 8.4.13
* PHP extensions : pdo_sqlite
* Package manager : Composer
* OS supported : Windows, Debian & Ubuntu

### Configuration

To configure the application, you'll need to set up your environment variables.

1.  Copy the example environment file:
    ```shell
    cp .env.example .env
    ```
2.  Open the `.env` file and edit the database variables to match your local setup. You can choose between SQLite, MySQL, or MariaDB by uncommenting the appropriate section.

### Installation & Setup

After cloning the repository and configuring your `.env` file, run the following commands from the root of the project to get everything set up.

1.  **Install PHP dependencies** using Composer:
    ```shell
    composer install
    ```
2.  **Update the autoloader** (optional, but good practice during development):
    ```shell
    composer dump-autoload
    ```
3.  **Run database migrations** to create the necessary tables:
    ```shell
    php database/migrate.php
    ```
4.  **(Optional) Seed the database** with initial mock data:
    ```shell
    php database/seed.php
    ```

## Want more documentation ?
[here the link to the wiki](https://github.com/CPNV-ES/Exercise-Looper-by-Andre-Ricardo-Joshua/wiki)

## Directory structure

```shell
├── database
│   ├── migrate.php
│   └── seed.php
├── public
│   ├── assets
│   ├── css
│   └── index.php                                   // Starting point for the web app
└── src
    ├── ConfigRoutes.php                            // Configuration of new routes
    ├── csrfToken.php
    ├── flashMessages.php
    ├── Renderer.php
    ├── Router.php
    ├── controllers
    │   ├── DatabaseController.php
    │   ├── ExerciseController.php
    │   └── HomeController.php
    ├── models                                      // All models
    │   ├── Answer.php
    │   ├── BaseModel.php                           // Abstract class
    │   └── ...
    └── views
        ├── errors                                  // Contain all errors views
        ├── exercises
        │   ├── answering-list.php
        │   ├── edit-field.php
        │   ├── fulfillment-form.php
        │   ├── manage-fields.php
        │   └── new.php
        ├── gabarit.php
        └── home.php

```
