<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Setz-PHP

A Laravel 12 application following Laravel standard conventions. For detailed framework information, see the [Laravel Documentation](https://laravel.com/docs).

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Vite, TailwindCSS, Alpine.js
- **Authentication:** [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)
- **Testing:** [Pest](https://pestphp.com/), PHPUnit, [Dusk](https://laravel.com/docs/dusk)
- **Quality Tools:** PHPStan, PHP Insights, Pint

## Installation

### Local Development (with Laravel Sail)

```bash
./install.sh
```

Starts Laravel Sail with PostgreSQL, Redis, Mailpit, and Selenium. Access at http://localhost

### Coder Workspace Development

This project automatically detects [Coder](https://coder.com) workspaces and configures itself accordingly (SQLite, local PHP, no Docker overhead).

**Initial Setup:**
```bash
~/setup-project.sh
```

**Start Development Server:**
```bash
cd ~/workspace
php artisan serve --host=0.0.0.0 --port=8000
```

The project will be available via Coder's port forwarding.

## Development Workflows

### Testing

**Watch Mode (continuous testing):**
```bash
# Pest (recommended)
./vendor/bin/pest --watch

# PHPUnit Watcher
./vendor/bin/phpunit-watcher watch
# or: make test-dev
```

**Single Run:**
```bash
composer test
# or: make test
```

**Browser Tests:**
```bash
php artisan dusk
# or: make browser_test
```

### Frontend Development

**Watch Mode:**
```bash
npm run dev
```

Starts Vite dev server with hot module replacement.

**Production Build:**
```bash
npm run build
```

### Parallel Development Workflow

Run all development services simultaneously:

```bash
composer dev
```

This starts:
- Queue Listener
- Laravel Pail (log viewer)
- Vite Dev Server

All in parallel with color-coded output.

### Code Quality

```bash
# Format code (Laravel Pint)
./vendor/bin/pint
# or: make pint

# Static Analysis (PHPStan)
./vendor/bin/phpstan analyse
# or: make phpstan

# Code Insights
./vendor/bin/phpinsights analyse
# or: make insights

# Fix code style issues
./vendor/bin/phpinsights analyse --fix
# or: make insights-fix

# Run all checks (pint + test + phpstan)
make check
```

## Database

**Coder Workspace:** SQLite (`database/database.sqlite`)
**Local Sail:** PostgreSQL

**Fresh Migration with Seed Data:**
```bash
php artisan migrate:fresh --seed
# or: make gen_data
```

**Create Test User:**
```bash
php artisan db:seed --class=UserSeeder
# or: make test_user
```
Credentials: `test@example.com` / `password`

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Bootcamp](https://bootcamp.laravel.com)
- [Laracasts](https://laracasts.com) (Video Tutorials)
- [Pest Documentation](https://pestphp.com/)
- [TailwindCSS](https://tailwindcss.com/)

## License

MIT License. See [LICENSE](https://opensource.org/licenses/MIT) for details.