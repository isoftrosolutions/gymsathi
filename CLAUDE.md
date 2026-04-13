# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**GymSathi** — a gym management SaaS platform built for Nepal's fitness market. Features member management, WhatsApp renewal reminders, eSewa/Khalti payment integration, and attendance tracking. Pricing in NPR.

Stack: **Laravel 13** (PHP 8.3+), **SQLite** (dev), Blade templates, **Tailwind CSS** (CDN via `cdn.tailwindcss.com`), no Vite/npm build pipeline yet.

## Development Commands

```bash
# First-time setup
composer run setup        # installs deps, copies .env, generates key, runs migrations, npm install+build

# Local development server
composer run dev          # starts artisan serve + queue worker + pail log viewer + vite concurrently

# Run all tests
composer run test         # clears config cache then runs phpunit

# Run a single test file or method
php artisan test tests/Feature/ExampleTest.php
php artisan test --filter=method_name

# Code formatting (Laravel Pint)
./vendor/bin/pint

# Database
php artisan migrate
php artisan db:seed
php artisan tinker
```

## Serving via Apache (current setup)

The project lives at `C:\Apache24\htdocs\gym`. The root `.htaccess` rewrites all requests to `public/`. Apache must have `mod_rewrite` enabled and `AllowOverride All` set for the htdocs directory. The app is served at `http://localhost/gym/`.

The `public/.htaccess` handles standard Laravel front-controller routing from there.

## Architecture

### Request Flow
`Apache` → root `.htaccess` rewrites to `public/` → `public/index.php` (Laravel bootstrap) → `routes/web.php` → Controller → Blade view

### Routes (`routes/web.php`)
- `GET /` → `HomeController@index` → `welcome` view
- `GET /sectors` → `HomeController@sectors` → `sectors` view
- `GET /login` → `AuthController@login` → `auth.login` view
- `POST /login` → `AuthController@store` → **TODO: authentication not yet implemented**

### View Layout System
All public pages extend `layouts.public` (`resources/views/layouts/public.blade.php`), which:
- Includes `partials.header` (fixed nav with GymSathi logo, links, Login button)
- Includes `partials.footer`
- Yields: `title`, `styles`, `content`, `scripts`

Tailwind config is inlined in the layout's `<head>` — dark mode class-based, custom Material Design 3 color tokens, custom font families (`headline` = Space Grotesk, `body`/`label` = Manrope).

Static CSS files for legacy/override styles: `public/css/landing.css`, `public/css/login.css`.

### Controllers
- `HomeController` — public marketing pages
- `AuthController` — login display + form handler (store() stub only, no real auth yet)

### Models
`User` model uses PHP 8 attribute-style `#[Fillable]` and `#[Hidden]` annotations (Laravel 13 feature). Password is auto-hashed via `casts()`.

### Database
SQLite at `database/database.sqlite`. Default migrations: users, cache, jobs tables. No custom migrations yet.

## Key Design Tokens
Primary accent: `#C8F135` (lime/`--primary-lime`). Dark background: `#111318`. Brand name references: "GymSathi", "Kinetic Gym Management".
