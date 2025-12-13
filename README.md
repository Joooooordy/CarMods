# Portfolio Laravel 12

A modern portfolio and e-commerce application built with Laravel 12 and Livewire 3, featuring a complete shopping experience, vehicle management system, and comprehensive admin panel.

## Features

### 🛍️ E-Commerce
- **Product Shop** - Browse and purchase products
- **Shopping Cart** - Add, update, and remove items
- **Checkout Process** - Complete billing, shipping, and payment flow
- **Payment Integration** - Mollie payment gateway integration

### 🚗 Vehicle Management
- **Add Vehicles** - Register vehicles by license plate (Dutch "kenteken")
- **Vehicle Details** - View detailed vehicle information

### 👥 User Management
- **Authentication** - Complete user registration and login system
- **User Profiles** - Manage user information and settings
- **Password Management** - Secure password updates
- **Role-Based Access** - Spatie Laravel Permission integration

### ⚙️ Admin Panel
- **Product Management** - CRUD operations for products
- **User Administration** - Manage users and permissions
- **PowerGrid Integration** - Advanced data tables and filtering

### 🎨 User Settings
- **Profile Settings** - Update personal information
- **Password Settings** - Change password securely
- **Appearance Settings** - Customize UI preferences

## Technology Stack

### Backend
- **Laravel 12** - PHP Framework
- **PHP 8.2+** - Programming Language
- **Livewire 3** - Full-stack framework for Laravel
- **Livewire Flux** - UI component library
- **Livewire Volt** - Single-file components
- **PowerGrid** - Advanced data tables
- **Spatie Laravel Permission** - Role and permission management
- **Mollie Laravel** - Payment gateway integration
- **Blade UI Kit** - Blade component library
- **Artisan UI** - Enhanced artisan commands UI

### Frontend
- **Alpine.js 3** - JavaScript framework with Morph and Persist plugins
- **TailwindCSS 4** - Utility-first CSS framework
- **Vite 7** - Frontend build tool
- **WireUI** - Livewire UI components
- **MaryUI** - Additional UI components
- **SweetAlert2** - Beautiful modals and alerts
- **Blade Icons** - Icon integration
- **FontAwesome** - Icon library

### Development Tools
- **PestPHP** - Testing framework
- **Laravel Pint** - Code style fixer
- **Laravel Pail** - Log viewer
- **Laravel Debugbar** - Debug toolbar
- **Laravel Sail** - Docker development environment (optional)

### Additional Libraries
- **jQuery** - JavaScript library
- **Flatpickr** - Date picker
- **Pikaday** - Alternative date picker
- **Inputmask** - Input masking
- **Typewriter Effect** - Animated typing effect
- **Axios** - HTTP client
- **Moment.js** - Date/time manipulation

## Requirements

- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **Node.js** >= 18 and **NPM** (JavaScript package manager)
- **Database** - SQLite (default), MySQL, or PostgreSQL
- **Mollie API credentials** (optional, for payment processing)

## Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd portfolio-laravel12
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install JavaScript Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
# Copy the example environment file (Windows)
copy .env.example .env

# Or on Linux/Mac
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Environment Variables
The default configuration uses **SQLite** database. Edit `.env` file if you need to customize:

**Basic Configuration:**
```env
APP_NAME="Portfolio Laravel 12"
APP_URL=http://localhost:8000
APP_ENV=local
APP_DEBUG=true
```

**Database (default SQLite):**
```env
DB_CONNECTION=sqlite
```

**For MySQL/PostgreSQL (optional):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**Queue & Cache:**
```env
QUEUE_CONNECTION=database
CACHE_STORE=database
SESSION_DRIVER=database
```

**Payment Gateway (optional):**
```env
# TODO: Add MOLLIE_KEY if using payment features
MOLLIE_KEY=your_mollie_api_key
```

**Mail (default to log):**
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 6. Database Setup
```bash
# Run migrations
php artisan migrate

# (Optional) Seed the database with sample data
php artisan db:seed
```

### 7. Storage Link
```bash
php artisan storage:link
```

## Development

### Available Scripts

**Composer Scripts:**
```bash
# Run all services concurrently (server + queue + vite)
composer dev

# Run tests
composer test
```

**NPM Scripts:**
```bash
# Start Vite development server with hot reload
npm run dev

# Build assets for production
npm run build
```

### Run Development Server

**Option 1: All-in-One (Recommended)**
```bash
composer dev
```
This command runs three services concurrently:
- Laravel development server (http://localhost:8000)
- Queue worker (processes background jobs)
- Vite dev server (hot module replacement for assets)

**Option 2: Run Separately**
```bash
# Terminal 1 - Laravel development server
php artisan serve

# Terminal 2 - Queue worker
php artisan queue:listen --tries=1

# Terminal 3 - Vite dev server
npm run dev
```

### Build for Production
```bash
npm run build
```

## Testing

This project uses **PestPHP** for testing.

### Run Tests
```bash
# Via Composer (clears config first)
composer test

# Via Artisan
php artisan test

# Via Pest directly
./vendor/bin/pest
```

### Test Suites
- **Unit Tests** - Located in `tests/Unit/`
- **Feature Tests** - Located in `tests/Feature/`

## Additional Artisan Commands

### Code Style
```bash
# Fix code style with Laravel Pint
./vendor/bin/pint
```

### Queue Management
```bash
# Process queue jobs
php artisan queue:work
```

### Log Viewing
```bash
# Tail application logs
php artisan pail
```

## Entry Points

### Web Application
- **Entry Point**: `public/index.php`
- **Routes**: Defined in `routes/web.php` and `routes/auth.php`
- **Vite Assets**: `resources/css/app.css` and `resources/js/app.js`

### Command Line
- **CLI Entry Point**: `artisan` (PHP script)
- **Console Routes**: Defined in `routes/console.php`
- **Available Commands**: Run `php artisan list` to see all commands

### Development Services
When running `composer dev`, the following services start:
1. **Laravel Server**: http://localhost:8000 (web application)
2. **Queue Worker**: Processes background jobs from the database
3. **Vite Dev Server**: Hot module replacement for frontend assets

## Project Structure

```
portfolio-laravel12/
├── app/
│   ├── Helpers/             # Helper functions
│   ├── Http/
│   │   ├── Controllers/     # HTTP Controllers (if any)
│   │   └── Livewire/        # Livewire Components
│   ├── Models/              # Eloquent models
│   ├── Providers/           # Service providers
│   ├── Services/            # Business logic services
│   └── View/                # View composers
├── bootstrap/               # Framework bootstrap
├── config/                  # Configuration files
├── database/
│   ├── factories/           # Model factories
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── lang/                    # Language files
├── public/                  # Public assets (entry point)
├── resources/
│   ├── css/                 # Stylesheets (app.css)
│   ├── font/                # Custom fonts
│   ├── js/                  # JavaScript (app.js)
│   ├── svg/                 # SVG assets
│   └── views/               # Blade templates
│       └── livewire/        # Livewire views
├── routes/
│   ├── auth.php             # Authentication routes
│   ├── console.php          # Console commands
│   └── web.php              # Web routes
├── storage/                 # Application storage (logs, cache, uploads)
├── tests/
│   ├── Feature/             # Feature tests
│   └── Unit/                # Unit tests
├── artisan                  # Artisan CLI
├── composer.json            # PHP dependencies
├── package.json             # JavaScript dependencies
├── phpunit.xml              # PHPUnit configuration
└── vite.config.js           # Vite configuration
```

## Key Routes

- `/` - Home page
- `/shop` - Product shop
- `/cart` - Shopping cart
- `/checkout/*` - Checkout process (billing, shipping, payment)
- `/voeg-auto-toe` - Add vehicle (Dutch: "Add car")
- `/kenteken/{vehicle}` - Vehicle details by license plate
- `/settings/*` - User settings (profile, password, appearance)
- `/settings/admin-user-panel` - Admin user management
- `/settings/admin-product-panel` - Admin product management

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues, questions, or contributions, please open an issue on the repository.

---

**Built with ❤️ using Laravel 12 and Livewire 3**
