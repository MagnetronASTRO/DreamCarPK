# DreamCarPK

Responsive web application for car rental, with managment for admin of car, reservations, users etc.

Full functionality on both web and mobile devices.

# Table of Contents

1. [Features](#features)
2. [Tech Stack](#tech-stack)
3. [Architecture](#architecture)
4. [Setup](#setup)
5. [User Manual](#user-manual)
6. [Admin Manual](#admin-manual)

## Features

- Consumer - browse cars for rental, reserve car, reservation history,
- Admin - same as consumer, manage users, cars, reservations,
- Responsive design - fully functional on both web and mobile devices,
- Quick instalation - app is contenarize and with following steps for installation it is easy to setup,

## Tech Stack

1. **PHP** - back-end site language for quick deployment.
2. **JavaScript** - front-end language for adding dynamic operations and actions.
3. **PostgreSQL** - the most advanced moder SQL database.
4. **Nginx** - high-performance web server.
5. **HTML5 and CSS3** - front-end, building and structuring UI.
6. **Docker** - containerization for quick, easy deployment and same dev experience on different environments.
7. **PHPUnit** - unit tests for PHP.
8. **Composer** - for easier use of php unit tests and psr-4 `namespace` `use`.

## Architecture

1. **App:**
    - `MVC (Model-View-Controller)` with Repository pattern, 
2. **Database:**


## Setup

    1. Clone repository and navigate to it.
    2. Run `composer install`.
    3. Set variables in `.env` file with secrets to database.
    4. Build container images `docker compose buil`.
    5. Start app with `docker compose up -d`.
    6. Default admin email `admin@example.com` pass `admin123`, change it in production.

## User Manual

## Admin Manual
