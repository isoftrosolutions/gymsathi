# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**GymSathi** — a multi-tenant gym management SaaS platform for Nepal's fitness market. Features member management, WhatsApp renewal reminders, eSewa/Khalti payment integration, and attendance tracking. Pricing in NPR.

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

The project lives at `C:\Apache24\htdocs\gym`. The root `.htaccess` rewrites all requests to `public/`. Apache must have `mod_rewrite` enabled and `AllowOverride All`. The app is served at `http://localhost/gym/`.

## Architecture

### Multi-Tenancy Model

This is a **single-database multi-tenant** system. Each gym is a `Tenant`. Users belong to a tenant via `tenant_id`. The `TenantScoped` trait (`app/Traits/TenantScoped.php`) automatically applies a global Eloquent scope filtering all queries by `auth()->user()->tenant_id` — except for `super_admin` users, who see everything. Any model representing gym-specific data should `use TenantScoped`.

There are two separate role systems:
- `platform_role` on `User` — platform-level access, currently only `super_admin`. Checked by `AdminMiddleware`.
- `role_id` on `User` → `Role` model with `Permission` pivot — per-tenant RBAC. Gates are dynamically registered from the `permissions` table in `AppServiceProvider`. Checked via `PermissionMiddleware` (alias `can`).

### Request Flow

`Apache` → root `.htaccess` → `public/index.php` → `bootstrap/app.php` (registers `IdentifyTenant` middleware globally + aliases `admin`, `can`) → `routes/web.php` → Controller → Blade view

`IdentifyTenant` middleware runs on every request and writes `app.tenant_id` to config if authenticated.

### Route Groups (`routes/web.php`)

- **Public** (`HomeController`) — `/`, `/about`, `/sectors`, `/support`, `/privacy`, `/security`, `/terms-of-service`, `/contact-support`
- **Auth** (`AuthController`) — `GET/POST /login`, `POST /logout`
- **Tenant dashboard** — `GET /dashboard` (middleware: `auth`)
- **Super admin panel** (`middleware: ['auth', 'admin']`, prefix `/admin`) — modules below:
  - `/admin/tenants` → `PlatformController` — CRUD + approve/reject/suspend/reactivate/transfer-ownership/reset-password
  - `/admin/subscriptions` → `SubscriptionController` + `ReportsController` — plan changes, trial extensions, revenue reports
  - `/admin/billing/{tenant}` → `BillingController` — payment recording, invoice generation/send
  - `/admin/support` → `SupportController` — ticket assign/reply/resolve/reopen/close/notes
  - `/admin/announcements` → `AnnouncementController` — create/edit/send/schedule
  - `/admin/activity` → `ActivityController` — per-tenant activity log + export
  - `/admin/impersonation` → `ImpersonationController` — start/stop impersonation sessions, audit log

### Domain Models

| Model | Key relationships |
|---|---|
| `Tenant` | `hasMany` Users, Subscriptions, Payments, SupportTickets, ActivityLogs |
| `User` | `belongsTo` Tenant, Role; uses `TenantScoped` trait |
| `Role` | `belongsToMany` Permission; uses `TenantScoped` |
| `Plan` | referenced by Subscription and Tenant.plan_id |
| `Subscription` | `belongsTo` Tenant, Plan; scopes: `active()`, `onTrial()` |
| `Payment` | `belongsTo` Tenant |
| `SupportTicket` | `belongsTo` Tenant; `hasMany` SupportMessages |
| `ActivityLog` | `belongsTo` Tenant; created via `Tenant::logActivity()` or `ActivityLog::logAction()` |
| `ImpersonationLog` | audit trail for admin impersonation sessions |
| `Announcement` | `belongsTo` Tenant (platform-wide or tenant-targeted) |

`Tenant` has rich business logic methods directly on the model: `approve()`, `reject()`, `suspend()`, `reactivate()`, `subscribeTo()`, `changePlan()`, `extendTrial()`, `getSubscriptionStatus()`.

### View Layout System

All public pages extend `layouts.public` (`resources/views/layouts/public.blade.php`), which includes `partials.header` and `partials.footer`. Yields: `title`, `styles`, `content`, `scripts`.

Tailwind config is inlined in the layout `<head>` — dark mode class-based, custom MD3 color tokens, `headline` font = Space Grotesk, `body`/`label` = Manrope.

Static CSS overrides: `public/css/landing.css`, `public/css/login.css`.

## Key Design Tokens

Primary accent: `#C8F135` (lime / `--primary-lime`). Dark background: `#111318`. Brand names: "GymSathi", "Kinetic Gym Management".

## Known TODOs

- `Tenant::getMemberCount()` returns a random placeholder — `Member` model not yet created
- Admin panel views (Blade templates for `/admin/*`) not yet scaffolded
- `DashboardController` referenced in routes but file not yet created
