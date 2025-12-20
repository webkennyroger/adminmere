# AdminMere - Copilot Instructions

## Project Overview
**AdminMere** is a Laravel 12 admin dashboard application using **Livewire 3**, **Volt**, and **Flux UI** for modern reactive frontend components. The app is built on Fortify for authentication with 2FA, Pest for testing, and Tailwind CSS v4 for styling.

### Key Stack
- **Backend**: Laravel 12, PHP 8.2+, Eloquent ORM
- **Frontend**: Livewire 3 (reactive components), Volt (single-file components), Flux UI v2
- **Styling**: Tailwind CSS v4 (CSS-first configuration)
- **Authentication**: Laravel Fortify with 2FA support
- **Testing**: Pest v4 with browser testing
- **Build**: Vite with Laravel plugin

---

## Critical Architecture Patterns

### 1. Volt Component Pattern
All interactive pages use **Livewire Volt** for class-based single-file components in `resources/views/livewire/`:
```blade
@volt
<?php
public function mount(): void { }
public function save(): void { }
public function updated($property): void { }
?>
<div><!-- Blade template --></div>
@endvolt
```
- **Always check existing Volt components** to match functional vs class-based convention
- Place new components in appropriate nested folders: `livewire/settings/`, `livewire/auth/`, etc.
- Use Fortify actions (`app/Actions/Fortify/`) for authentication logic

### 2. Routing & Views
- Routes defined in `routes/web.php` using `Volt::route()` for Volt pages
- Standard blade views in `resources/views/`
- Layout structure: `x-layouts.app` is the main wrapper (check `components/layouts/`)
- Protected routes use `middleware(['auth', 'verified'])`
- Dashboard redirects unauthenticated users to login (Fortify handles auth views)

### 3. Data Flow
- Livewire components manage **server-side state** (properties, reactive updates)
- Validate form data in component methods or Fortify Actions
- Use `wire:model.live` for real-time updates, `wire:model` is deferred
- Dispatch events with `$this->dispatch()` for cross-component communication
- Eager load relationships with `with()` to prevent N+1 queries

---

## Frontend Conventions

### Flux UI Usage
Located in `resources/views/` and imported as `<flux:component>`:
- **Available**: button, input, select, checkbox, radio, textarea, field, modal, dropdown, badge, callout, heading, icon, separator, text, avatar, breadcrumbs, navbar, profile, brand, tooltip
- Requires Blade `@slot` syntax for complex layouts
- Pair with `wire:model`, `wire:click` for Livewire integration

### Tailwind CSS v4
- Configuration is **CSS-first** in `resources/css/app.css` using `@theme` directive
- **No `tailwind.config.js`** needed for basic customization
- Import using `@import "tailwindcss";` (not `@tailwind` directives from v3)
- Opacity utilities: use `bg-black/50` instead of deprecated `bg-opacity-50`
- Spacing: use `gap-` utilities for flex gaps (not margins on children)

### Dark Mode
- All components must support light/dark modes using `dark:` prefix
- Toggle with `x-data` + Alpine: `x-on:click="$flux.dark = !$flux.dark"`
- Check existing dashboard for dark mode patterns in modals and dropdowns

---

## Development Workflow

### Build & Run
```bash
composer run dev       # Concurrent: Laravel serve, queue:listen, Vite dev
npm run dev            # Vite dev server (included in composer dev)
php artisan test       # Run Pest tests
vendor/bin/pint --dirty  # Format code before commit
```

### Artisan Commands
- `php artisan make:volt [name]` - Create Volt component
- `php artisan make:livewire [Name]` - Create Livewire component (if needed)
- `php artisan make:test [Name] --pest` - Create Pest test
- All commands support `--no-interaction` for automation

### File Structure
```
app/
├── Actions/Fortify/      # Authentication business logic
├── Livewire/            # Full Livewire components (if needed)
└── Models/              # Eloquent models
resources/views/
├── components/
│   ├── layouts/         # Main layout wrapper
│   └── settings/        # Reusable setting components
└── livewire/
    ├── settings/        # Volt pages for user settings
    └── auth/            # Auth-related Volt pages
tests/
├── Feature/             # Feature tests (default)
└── Unit/                # Unit tests
```

---

## Authentication & Authorization

### Fortify Setup
- Configured in `config/fortify.php` with enabled features
- Features include: registration, email verification, 2FA, password reset
- Fortify routes auto-registered (use `list-artisan-commands` to view)
- Override views/actions in `FortifyServiceProvider::boot()`

### Two-Factor Authentication
- Located in `resources/views/livewire/settings/two-factor.blade.php`
- Uses `EnableTwoFactorAuthentication`, `ConfirmTwoFactorAuthentication` actions
- Recovery codes managed separately in `two-factor/recovery-codes.blade.php`

### Authorization
- Use Laravel policies or gates for role-based checks
- Add policies to `App\Policies\`
- Check authorization in Volt methods: `$this->authorize('method', Model)`

---

## Testing Approach

### Pest Conventions
- All tests use Pest syntax (not PHPUnit directly)
- Place in `tests/Feature/` (default) or `tests/Unit/`
- Use `$this->faker` or `fake()` for Faker (check existing tests for convention)
- Run filtered tests: `php artisan test --filter=testName`

### Test Data
- Use factories from `database/factories/` via `User::factory()->create()`
- Use model states in factories for specific conditions
- Pest provides `actingAs(User)` for authenticated contexts

### Browser Testing (Pest v4)
- Use for UI validation, form submission, dark mode testing
- `visit('/path')` returns a page object with assertion methods
- Smoke test multiple pages at once: `visit(['/', '/about', '/contact'])`

---

## Code Quality Standards

### PHP Style
- Always use explicit return types and type hints
- Use PHP 8 constructor property promotion: `public function __construct(public Service $service) {}`
- Use curly braces for all control structures (even single-line)
- Use PHPDoc blocks, not inline comments (unless very complex)

### Validation & Error Handling
- Create Form Request classes for controller validation
- Livewire: validate in methods or use `#[Validate()]` attributes
- Always validate and authorize in component methods
- Return specific HTTP status codes: `assertForbidden()`, `assertNotFound()`

### Database
- Use Eloquent relationships with return type hints
- Eager load with `->with()` or `->load()`
- Prefer relationships over raw queries
- Migrations use builder syntax, not raw SQL

---

## Debugging & Tools

### Laravel Boost (MCP Server)
- `search-docs` - Query version-specific docs for installed packages
- `tinker` - Execute PHP code in app context
- `database-query` - Read-only SQL queries
- `list-routes` - View all registered routes
- `list-artisan-commands` - Available Artisan commands

### Browser DevTools
- Check `browser-logs` for frontend errors
- Livewire network tab shows component requests
- Dark mode toggle via Alpine: inspect `$flux.dark` state

### Common Issues
- **Vite manifest error**: Run `npm run build` or `composer run dev`
- **Session expired (419)**: Check `livewire:init` hook in `resources/js/app.js`
- **N+1 queries**: Use `with()` on relationship loads
- **Missing components**: Verify Volt path matches route definition

---

## Conventions Specific to AdminMere

1. **Settings Pages**: All in `livewire/settings/` as Volt components (profile, password, appearance, 2FA)
2. **Dashboard Data**: Mixed use of Volt for interactive sections + static HTML with charts
3. **Component Reuse**: Check `resources/views/components/settings/` before creating new UI patterns
4. **Form Handling**: Fortify Actions handle business logic; Volt just calls them
5. **Layout Sidebar**: Managed by Flux UI components; toggle state via `data-sidebar="trigger"`

---

## Key Files to Reference
- `app/Actions/Fortify/` - Auth logic examples
- `resources/views/livewire/settings/` - Volt component patterns
- `routes/web.php` - Route and middleware examples
- `resources/views/dashboard.blade.php` - Main dashboard layout with Flux/Tailwind examples
- `resources/css/app.css` - Tailwind v4 configuration and theme customization
- `composer.json` - Available scripts and package versions
