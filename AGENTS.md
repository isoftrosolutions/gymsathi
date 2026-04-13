# GymSathi - Agent Guidelines

## Project Overview
GymSathi is a gym management SaaS platform built for Nepal's fitness market. It features member management, WhatsApp renewal reminders, eSewa/Khalti payment integration, and attendance tracking. Built with Laravel 13 (PHP 8.3+), SQLite (dev), Blade templates, and Tailwind CSS via CDN.

## Build/Lint/Test Commands

### First-Time Setup
```bash
composer run setup        # installs deps, copies .env, generates key, runs migrations, npm install+build
```

### Development Server
```bash
composer run dev          # starts artisan serve + queue worker + pail log viewer + vite concurrently
```

### Testing
```bash
composer run test         # clears config cache then runs phpunit
```

### Single Test Execution
```bash
php artisan test tests/Feature/ExampleTest.php
php artisan test --filter=method_name
```

### Code Formatting
```bash
./vendor/bin/pint
```

## Code Style Guidelines

### PHP Standards
- **PHP Version**: 8.3+
- **Framework**: Laravel 13
- **Indentation**: 4 spaces (configured in .editorconfig)
- **Line Endings**: LF (Unix)
- **Encoding**: UTF-8
- **Autoloading**: PSR-4 standard
- **Naming**: PascalCase for classes, camelCase for methods/properties

### Laravel-Specific Patterns

#### Controllers
- Use type hints for return values: `public function index(): View`
- Use controller groups for related routes
- Extend base `Controller` class
- Use descriptive PHPDoc comments

#### Models
- Use Laravel 13 attribute-style annotations: `#[Fillable]`, `#[Hidden]`
- Define casts() method for attribute casting
- Use generic types in PHPDoc: `/** @use HasFactory<UserFactory> */`

#### Routes
- Group related routes by controller
- Use named routes consistently
- Separate public and authenticated routes

### Blade Templates
- Extend layout files: `@extends('layouts.public')`
- Use `@yield()` and `@section()` for content injection
- Include partials with `@include('partials.header')`
- Consistent indentation and readable structure

### Frontend Styling
- **CSS Framework**: Tailwind CSS v4 (via CDN)
- **Design System**: Material Design 3 color tokens
- **Dark Mode**: Class-based theming
- **Fonts**:
  - Headline: Space Grotesk
  - Body/Label: Manrope
- **Custom Colors**: Primary accent `#C8F135` (lime)
- **Background**: Dark theme `#111318`

### Import Organization
- Group imports by type: classes, facades, traits
- Use fully qualified class names
- Alphabetical ordering within groups
- One import per line

### Error Handling
- Use Laravel's built-in validation
- Return appropriate HTTP status codes
- Provide meaningful error messages
- Use try-catch blocks for expected exceptions

### Database
- **Development**: SQLite (`database/database.sqlite`)
- **Migrations**: Standard Laravel structure
- **Seeders**: Use factories for test data
- **Models**: Define relationships and casts

### Testing
- **Framework**: PHPUnit
- **Structure**: Feature and Unit test directories
- **Naming**: `test_method_name_description`
- **Assertions**: Use Laravel's testing helpers
- **Database**: Use in-memory SQLite for testing

### File Structure
```
app/
├── Http/Controllers/
│   ├── Auth/
│   └── HomeController.php
├── Models/
└── Providers/

resources/
├── views/
│   ├── layouts/
│   ├── partials/
│   └── auth/
└── css/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

### Commit Guidelines
- Use descriptive commit messages
- Follow conventional commit format when possible
- Test before committing
- Use `./vendor/bin/pint` for code formatting

### Security Best Practices
- Never commit `.env` files
- Use Laravel's built-in CSRF protection
- Validate all user inputs
- Use hashed passwords (automatic via casts)
- Follow Laravel security guidelines

### Performance Considerations
- Use eager loading for relationships
- Cache frequently accessed data
- Optimize database queries
- Use pagination for large datasets
- Consider lazy loading for assets

### Development Workflow
1. Run `composer run setup` for new installations
2. Use `composer run dev` for development
3. Write tests for new features
4. Format code with `./vendor/bin/pint`
5. Run tests with `composer run test`
6. Commit changes with descriptive messages