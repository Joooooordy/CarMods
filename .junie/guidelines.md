# Development Guidelines - Laravel 12 Portfolio Project

## Project Overview
This is a Laravel 12 application using Livewire 3, with Tailwind CSS v4, and multiple UI component libraries (Flux, WireUI, Mary UI). The project is designed for Windows development with PowerShell.

## Build & Configuration

### Initial Setup
1. **Environment Configuration**:
   ```powershell
   # Copy environment file
   copy .env.example .env
   
   # Generate application key
   php artisan key:generate
   
   # Create SQLite database (if using SQLite)
   New-Item -ItemType File -Path database\database.sqlite -Force
   
   # Run migrations
   php artisan migrate
   ```

2. **Install Dependencies**:
   ```powershell
   # PHP dependencies
   composer install
   
   # Node dependencies
   npm install
   ```

### Database Configuration
- **Default**: SQLite (`DB_CONNECTION=sqlite`)
- **Testing**: Uses in-memory SQLite (`:memory:`) - **requires `pdo_sqlite` PHP extension**
- **Alternative**: MySQL is available if SQLite extension is not enabled
- Check available extensions: `php -m | Select-String -Pattern "sqlite|pdo"`

### Running the Application

**Option 1: Concurrent Development Mode (Recommended)**
```powershell
composer dev
```
This runs three processes concurrently:
- Laravel development server (`php artisan serve`)
- Queue worker (`php artisan queue:listen --tries=1`)
- Vite dev server with hot reload (`npm run dev`)

**Option 2: Separate Processes**
```powershell
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Queue worker
php artisan queue:listen

# Terminal 3: Vite dev server
npm run dev
```

### Building Assets
```powershell
# Development build
npm run dev

# Production build
npm run build
```

**Vite Configuration**:
- Entry points: `resources/css/app.css`, `resources/js/app.js`
- Uses Tailwind CSS v4 via `@tailwindcss/vite` plugin
- Hot module replacement enabled

## Testing

### Testing Framework
The project uses **Pest** (v3.8) with Laravel plugin for testing.

### Test Configuration
- **Framework**: Pest PHP (functional syntax)
- **Location**: `tests/` directory
  - `tests/Feature/` - Feature tests (use RefreshDatabase)
  - `tests/Unit/` - Unit tests (no database)
- **Configuration**: `tests/Pest.php`, `phpunit.xml`
- **Test Environment**:
  - Database: In-memory SQLite
  - Cache/Mail/Session: Array drivers
  - Queue: Sync connection

### Running Tests

**All tests**:
```powershell
php artisan test
```

**Or using composer script**:
```powershell
composer test
```

**Specific test suite**:
```powershell
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature
```

**Filter by test name**:
```powershell
php artisan test --filter=SpecificTestName
```

**Specific file**:
```powershell
php artisan test tests\Unit\ExampleTest.php
```

### Writing Tests

**Unit Test Example** (no database):
```php
<?php

test('basic math calculation', function () {
    $result = 2 + 2;
    
    expect($result)->toBe(4);
});

test('array operations', function () {
    $array = [1, 2, 3];
    
    expect($array)->toHaveCount(3);
    expect($array)->toContain(2);
});
```

**Feature Test Example** (with database):
```php
<?php

test('returns a successful response', function () {
    $response = $this->get('/');
    
    $response->assertStatus(200);
});
```

**Important Notes**:
- Feature tests automatically use `RefreshDatabase` trait (configured in `tests/Pest.php`)
- For Feature tests to work, **PHP must have `pdo_sqlite` extension enabled**
- If SQLite extension is missing, write Unit tests without database dependencies
- Use Pest's `expect()` syntax for assertions
- Global test helpers can be added in `tests/Pest.php`

## Code Style

### PHP Code Formatting
- **Tool**: Laravel Pint (v1.18)
- **Preset**: Laravel (default, no custom configuration)
- **Usage**:
  ```powershell
  # Format all files
  vendor\bin\pint
  
  # Check without fixing
  vendor\bin\pint --test
  
  # Format specific files/directories
  vendor\bin\pint app\Http\Livewire
  ```

### Code Conventions
- **Namespace Structure**: Follow PSR-4 autoloading
- **Livewire Components**: Located in `app\Http\Livewire\` namespace
- **Helper Functions**: Defined in `app\Helpers\helpers.php` (auto-loaded via composer.json)
- **Views**: Blade templates in `resources\views\`, Livewire views in `resources\views\livewire\`

### Livewire Component Structure
Standard Livewire component pattern:
```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ComponentName extends Component
{
    // Public properties (reactive)
    public $property;
    
    // Lifecycle hooks
    public function mount()
    {
        // Initialize component
    }
    
    // Actions
    public function actionMethod()
    {
        // Logic here
        $this->dispatch('event-name');
    }
    
    // Render
    public function render()
    {
        return view('livewire.component-name');
    }
}
```

## Key Dependencies

### PHP Packages
- **Laravel Framework**: v12.0
- **Livewire**: v3.6 (with Volt v1.7, Flux v2.1)
- **UI Libraries**: WireUI, Mary UI, PowerGrid
- **Authentication/Authorization**: Spatie Laravel Permission
- **Payment**: Mollie Laravel
- **Icons**: Blade Icons, Blade FontAwesome
- **Dev Tools**: Laravel Debugbar, Laravel Pail (log viewer), Tinker

### JavaScript Packages
- **Alpine.js**: v3.14.9 (with Morph and Persist plugins)
- **Build Tool**: Vite v7.1.11
- **Styling**: Tailwind CSS v4.1.18
- **Other**: Axios, jQuery, Flatpickr, SweetAlert2, Typewriter Effect

## Windows-Specific Notes
- **Terminal**: Use PowerShell (not Bash)
- **Path Separators**: Use backslashes (`\`) in paths
- **Command Chaining**: Use `;` instead of `&&`
- **File Operations**: Use PowerShell cmdlets (e.g., `New-Item`, `Copy-Item`)

## Common Development Tasks

### Clear Caches
```powershell
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Database Operations
```powershell
# Fresh migration
php artisan migrate:fresh

# With seeding
php artisan migrate:fresh --seed

# Rollback
php artisan migrate:rollback
```

### Artisan UI
The project includes `yungifez/artisan-ui` for visual Artisan command management.

### Queue Management
- **Connection**: Database (uses `jobs` table)
- **Worker**: `php artisan queue:listen --tries=1`
- **Monitor**: Included in `composer dev` script

## Debugging
- **Laravel Debugbar**: Available in development (requires `barryvdh/laravel-debugbar`)
- **Laravel Pail**: Real-time log viewer (`php artisan pail`)
- **Log Location**: `storage\logs\laravel.log`
- **Tinker**: Interactive REPL (`php artisan tinker`)

## Testing Gotchas
1. **SQLite Extension**: Feature tests require `pdo_sqlite` PHP extension. If missing, enable it in `php.ini`:
   ```ini
   extension=pdo_sqlite
   ```
2. **In-Memory Database**: Test database is recreated for each test (defined in `phpunit.xml`)
3. **Test Isolation**: Use `RefreshDatabase` trait for database tests to ensure clean state
