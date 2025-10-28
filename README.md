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

List all dependencies and their version needed by the project as :

* DataBase Engine (MySql, PostgreSQL, MSSQL,...)
* IDE used : PhpStorm
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

## Directory structure

* Tip: try the tree bash command

```shell
├───Docs
├───Shopping                                        //classes and packages
│   ├───bin                                         //the binary to deploy on the end-user environment
│   │   └───Debug
│   └───obj
│       └───Debug                                   
└───TestShopping                                    //test classes
    ├───bin
    │   └───Debug
    └───obj
        └───Debug
```

## Collaborate

* Take time to read some readme and find the way you would like to help other developers collaborate with you.

* They need to know:
    * How to propose a new feature (issue, pull request)
    * [How to commit](https://www.conventionalcommits.org/en/v1.0.0/)
    * [How to use your workflow](https://nvie.com/posts/a-successful-git-branching-model/)

## License

* [Choose the license adapted to your project](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/licensing-a-repository).

## Contact

* How to get in contact with you? Discord, Trello, Issue?