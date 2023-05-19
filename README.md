# Teknasyon API

API [ MEDIUM ] was developed in this project.
Used https://github.com/dunglas/symfony-docker for dockerizing and step debugging the project.

## Features

* Registration: Controller/API/v1/RegistrationController.php
* Check Subscription: Controller/API/v1/SubscriptionController.php
* Purchase: Controller/API/v1/PurchaseController.php
* Migrations: /migrations
* Repositories: /Repository
* Entities: /Entity
* Factories: /Factory
* Services: /Service/API and /Service/MockAPI

To install docker containers;
* Install docker on your system
* docker compose build --pull --no-cache
* docker compose up -d
* go to https://localhost


Debugging
* to enable debugging with xdebug: XDEBUG_MODE=debug docker compose up -d
* you have to check out https://github.com/dunglas/symfony-docker/blob/main/docs/xdebug.md to name the servername and initiate remote debugging properly.