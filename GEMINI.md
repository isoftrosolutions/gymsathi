# GymSathi - Kinetic Gym Management System

GymSathi is an all-in-one gym management system designed specifically for the modern fitness landscape in Nepal. It aims to automate facility operations, including member management, payment tracking, and automated communication.

## Project Overview

- **Technologies:** Laravel 13, PHP 8.3, Vite, Tailwind CSS (v4).
- **Architecture:** Standard Laravel MVC architecture.
- **Key Features:**
    - Digital member tracking and instant search.
    - Automated renewal reminders via SMS/WhatsApp.
    - Local payment integrations (eSewa, Khalti).
    - Real-time revenue tracking and dashboard.
    - Multi-sector solutions (Gyms, CrossFit, Yoga, etc.).

## Getting Started

### Prerequisites
- PHP 8.3 or higher
- Composer
- Node.js & npm
- SQLite (default) or other supported database

### Setup and Installation
The project includes a comprehensive setup script defined in `composer.json`:

```bash
# Full project setup (Install dependencies, generate key, migrate, build assets)
composer run setup
```

Alternatively, manual setup:
1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`
4. `php artisan migrate`
5. `npm install`
6. `npm run build`

### Running the Project
For development with hot-reloading and background processes:

```bash
# Starts serve, queue, logs, and vite concurrently
composer run dev
```

Or individually:
- **Server:** `php artisan serve`
- **Frontend Dev:** `npm run dev`

### Testing
```bash
composer run test
# OR
php artisan test
```

## Development Conventions

- **Framework Patterns:** Follow standard Laravel conventions for Controllers, Models, and Migrations.
- **Views:** Blade templates are located in `resources/views`. Main pages include `welcome.blade.php`, `sectors.blade.php`, and `auth/login.blade.php`.
- **Styles:** Tailwind CSS (v4) is the primary styling framework. Custom CSS files can be found in `public/css/` (e.g., `landing.css`, `login.css`).
- **Assets:** Managed via Vite. Configuration is in `vite.config.js` and `package.json`.
- **Local Context:** The `desgins/` directory contains HTML/CSS prototypes and design source files used for reference during Blade implementation.
- **Environment:** Configuration is managed via the `.env` file. Ensure `APP_KEY` is set and database is configured.

## Directory Structure Highlights
- `app/`: Application logic (Controllers, Models, Providers).
- `config/`: Application configuration files.
- `database/`: Migrations, seeders, and factories.
- `desgins/`: Prototype designs and source assets.
- `public/`: Publicly accessible assets (CSS, images).
- `resources/`: Frontend assets (Blade views, JS, CSS).
- `routes/`: Web and console route definitions.
- `tests/`: Automated test suites.
