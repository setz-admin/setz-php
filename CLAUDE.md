# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Setz-PHP is a Laravel 12 appointment management application with integrated RAG (Retrieval-Augmented Generation) chatbot functionality. The application manages appointments between customers and employees with service tracking and invoicing. It uses Laravel Breeze for authentication, Pest for testing, and supports both local Docker (Laravel Sail) and Coder Workspace environments.

**NEW: RAG Integration** - Python-based document Q&A system:
- Backend integration complete (PythonServiceClient + ChatController)
- 9 API endpoints for chat, documents, and vector store
- 8 integration tests passing
- Frontend UI pending implementation

## Environment Detection

The project automatically adapts to two environments:

- **Coder Workspace**: Uses SQLite, local PHP, no Docker
- **Local Development**: Uses Laravel Sail with Docker (PostgreSQL, Redis, Mailpit, Selenium)

Detection is automatic via `$CODER_WORKSPACE_NAME` environment variable.

## Common Commands

### Setup

```bash
# Local (Sail): Full Docker setup with PostgreSQL
./install.sh

# Coder Workspace: SQLite setup
~/setup-project.sh

# Rebuild Sail environment
./install.sh --rebuild
```

### Development Server

```bash
# Coder Workspace
php artisan serve --host=0.0.0.0 --port=8000

# Local Sail
./vendor/bin/sail up

# Parallel development (queue, logs, vite) - both environments
composer dev
```

### Testing

```bash
# Run tests (Pest)
composer test
# or: ./vendor/bin/sail test

# Watch mode (continuous testing)
./vendor/bin/pest --watch
# or: ./vendor/bin/phpunit-watcher watch
# or: make test-dev

# Browser tests (Dusk)
php artisan dusk
# or: make browser_test

# Run single test file
./vendor/bin/pest tests/Feature/CustomerTest.php

# Run single test by name
./vendor/bin/pest --filter test_customer_can_be_created
```

### Code Quality

```bash
# Format code (Laravel Pint)
./vendor/bin/pint
# or: make pint

# Static analysis (PHPStan - larastan)
./vendor/bin/phpstan analyse
# or: make phpstan

# Code insights (architecture, style, complexity)
./vendor/bin/phpinsights analyse
# or: make insights

# Auto-fix insights
./vendor/bin/phpinsights analyse --fix
# or: make insights-fix

# Run all quality checks
make check
```

### Frontend

```bash
# Development with HMR
npm run dev

# Production build
npm run build
```

### Database

```bash
# Fresh migration with seed data
php artisan migrate:fresh --seed
# or: make gen_data

# Create test user (test@example.com / password)
php artisan db:seed --class=UserSeeder
# or: make test_user
```

## Architecture

### Domain Models

Core business entities with relationships:

- **Customer** - Has many appointments
- **Employee** - Has many appointments
- **Appointment** - Belongs to customer and employee, has many services
- **Service** - Belongs to appointment, pivot with invoice
- **Invoice** - Belongs to appointment, has many services through pivot

All models use `final` class declaration. Use `HasFactory` trait for testing with factories.

### Authentication

Laravel Breeze installed with Blade views. All routes except `/` require authentication. Email verification enabled on dashboard.

### Controllers

RESTful resource controllers for all domain models (Customer, Employee, Appointment, Service, Invoice). All authenticated routes are protected via `auth` middleware group in `routes/web.php`.

### Testing Strategy

- **Unit tests**: `tests/Unit/` - Model logic, utilities
- **Feature tests**: `tests/Feature/` - HTTP requests, authentication, CRUD operations
- **Browser tests**: `tests/Browser/` - Dusk end-to-end tests

Tests use in-memory SQLite database (configured in `phpunit.xml`). Pest is the primary test framework with PHPUnit available as fallback.

### Frontend Stack

- **Vite**: Build tool with HMR
- **TailwindCSS 3**: Utility-first CSS (@tailwindcss/forms plugin included)
- **Alpine.js**: Lightweight JavaScript framework for interactivity
- Blade templates in `resources/views/`

### Code Style

- **PHP 8.2+** strict types (`declare(strict_types=1)`)
- **PSR-12** coding standard (enforced by Pint)
- **PHPStan Level 5+** static analysis (larastan configuration in `phpstan.neon`)
- **Final classes** for models
- Type hints on all methods

## Database Environments

- **Local Sail**: PostgreSQL (`DB_CONNECTION=pgsql`)
- **Coder Workspace**: SQLite (`database/database.sqlite`)
- **Testing**: In-memory SQLite (`:memory:`)

All migrations must be compatible with both PostgreSQL and SQLite.

## RAG Chatbot Integration

### Backend Components (Complete)
- **Service**: `app/Services/PythonServiceClient.php` - HTTP client for Python RAG service
- **Controller**: `app/Http/Controllers/ChatController.php` - API proxy with 9 endpoints
- **Routes**: `routes/api.php` - Chat API routes with Sanctum authentication
- **Config**: `config/services.php` - Python service configuration
- **Tests**: `tests/Feature/ChatIntegrationTest.php` - 8 integration tests

### Frontend Components (Pending)
- [ ] Chat interface (`resources/views/chat/index.blade.php`)
- [ ] Document management (`resources/views/chat/documents.blade.php`)
- [ ] Admin dashboard (`resources/views/admin/rag-stats.blade.php`)
- [ ] Navigation integration

### API Endpoints
```
GET  /api/chat/health                    - Health check (public)
POST /api/chat/message                   - Send message (auth required)
POST /api/chat/conversations             - Create conversation
GET  /api/chat/conversations/{id}        - Get conversation
GET  /api/chat/documents                 - List documents
POST /api/chat/documents                 - Upload document
GET  /api/chat/documents/{id}/status     - Document status
DELETE /api/chat/documents/{id}          - Delete document
GET  /api/chat/stats                     - Vector store stats
```

### Configuration
Set in `.env`:
```
PYTHON_RAG_BASE_URL=http://localhost:8000
PYTHON_RAG_TIMEOUT=30
```

### Related Documentation
- Implementation Status: `IMPLEMENTATION_STATUS.md`
- Python Service: `../setz-ki-webpage/IMPLEMENTATION_STATUS.md`
- Requirements (German): `../setz-ki-webpage/req/README.md`

## Key Files

- `routes/web.php` - Web routes (resource routes for domain models)
- `routes/api.php` - API routes including RAG chat endpoints
- `app/Services/PythonServiceClient.php` - RAG service integration
- `app/Http/Controllers/ChatController.php` - RAG API controller
- `composer.json` - Composer scripts including `dev` for parallel development
- `Makefile` - Common task shortcuts (all prefixed with `./vendor/bin/sail`)
- `install.sh` - Environment-aware setup script
- `phpunit.xml` - Test configuration with in-memory SQLite
- `phpstan.neon` - Static analysis configuration
- `pint.json` - Code formatting rules
