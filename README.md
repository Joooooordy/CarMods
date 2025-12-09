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

### Frontend
- **Alpine.js 3** - JavaScript framework
- **TailwindCSS 4** - Utility-first CSS framework
- **Vite** - Frontend build tool
- **WireUI** - Livewire UI components
- **MaryUI** - Additional UI components
- **SweetAlert2** - Beautiful modals and alerts
- **Blade Icons** - Icon integration
- **FontAwesome** - Icon library

### Additional Libraries
- **jQuery** - JavaScript library
- **Flatpickr** - Date picker
- **Pikaday** - Alternative date picker
- **Inputmask** - Input masking
- **Typewriter Effect** - Animated typing effect
- **Axios** - HTTP client

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/PostgreSQL/SQLite database
- Mollie API credentials (for payment processing)

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
# Copy the example environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Environment Variables
Edit `.env` file and configure:
```env
APP_NAME="Your App Name"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MOLLIE_KEY=your_mollie_api_key
```

### 6. Database Setup
```bash
# Run migrations
php artisan migrate

# (Optional) Seed the database
php artisan db:seed
```

### 7. Storage Link
```bash
php artisan storage:link
```

## Development

### Run Development Server
Use the convenient development command that runs server, queue, and vite concurrently:
```bash
composer dev
```

Or run them separately:
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

Run the test suite:
```bash
composer test
# or
php artisan test
```

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

## Project Structure

```
portfolio-laravel12/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # HTTP Controllers
│   │   └── Livewire/        # Livewire Components
│   └── Helpers/             # Helper functions
├── config/                  # Configuration files
├── database/
│   ├── factories/           # Model factories
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── views/               # Blade templates
│   └── css/                 # Stylesheets
├── routes/
│   ├── web.php              # Web routes
│   └── auth.php             # Authentication routes
├── storage/                 # Application storage
├── tests/                   # Test files
└── public/                  # Public assets
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
