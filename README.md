# Management Information System

## Table of Contents
- [Tech Stack](#tech-stacks)
- [Development Setup](#development-setup)
- [Production Setup](#production-setup)
	- [Migrating from development](#migrating)
	- [Backups](#backups)

## Tech Stacks
| Badge | Type | Name | Version | Description |
| --- | --- | --- | :-: | --- |
|![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) | PL | PHP | ^8.1 | Primary Programming Language |
| ![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white) | Framework | Laravel | ^8 | PHP framework used|
|![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&logo=mariadb&logoColor=white)| Database | MariaDB | ^10 | Database used |
| ![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white) | VM | Docker | ^20.10 | Virtualization environment |
|![Git](https://img.shields.io/badge/git-%23F05033.svg?style=for-the-badge&logo=git&logoColor=white) | Source Code | Git | ^2.40 | Used for versioning control and uploading source code to Github |

## Development Setup

This program was developed in Ubuntu 21.10. If you plan to develop this program on Windows, please use WSL and add Ubuntu on your distro lists.

 1. Check your OS if you installed docker by running: `docker -v`. If the return output returns similar like this: **`Docker version 20.10.12, build e91ed57`**, docker is already installed in your machine. If docker is not present, refer to this installation guide:  
[Docker Engine Setup for Ubuntu](https://docs.docker.com/engine/install/ubuntu/#install-using-the-convenience-script).  
This script also install *docker-compose* which is also a vital development program for our project.
 2. Clone this repository from Github by running this command:  
	`git clone https://github.com/auroragovph/mis.git`
3. Now you need to change directory to project's root folder and run the following command:  
	`cd mis` - Changing directory to mis root directory  
	`cp .env.example .env` - Copy environment variables  
4. Install project dependency using docker to isolate the project from the host computer. Run the following command:  
`docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php81-composer:latest composer install --ignore-platform-reqs`
5. Now, we can start the development server by running: `./vendor/bin/sail up -d`
6. Configure the program by running this commands:  
`./vendor/bin/sail artisan key:generate` - Generate application key of the program  
`./vendor/bin/sail artisan migrate` - Migrate the database schema  
`./vendor/bin/sail artisan db:seed` - Generate required initial data like offices and users to our program  
`./vendor/bin/sail yarn install` - Install front end dependencies  
`./vendor/bin/sail yarn dev` - Compile front-end assets
7. You can now access the programming in `localhost` 
