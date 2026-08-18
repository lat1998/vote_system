# Voting System

A secure online voting platform built with Laravel 13. Administrators can manage elections and candidates, while registered voters can securely log in, cast ballots, and view results. The REST API uses Laravel Sanctum for token-based authentication and role-based access control.

## Features

- Secure web login and registration for voters and admins
- Role-based admin access for protected features and reports
- Election and candidate management
- One vote per voter per election with confirmation pages
- Public read-only API endpoints for elections and candidates
- Protected API vote casting and logout endpoints using Bearer tokens
- Export results in CSV, JSON, and HTML formats
- Static documentation deployable via GitHub Pages

## Technology Stack

| Layer | Technology |
|-------|------------|
| Backend | PHP 8.3, Laravel 13 |
| Frontend | Bootstrap 5, Blade templates, Bootstrap Icons |
| Database | SQLite (default), MySQL, or PostgreSQL |
| Charts | Chart.js |
| API Auth | Laravel Sanctum (Bearer tokens) |
| Testing | Pest PHP 4 |

## Requirements

- PHP 8.3+
- Composer
- Node.js & npm (optional, for Vite assets)
- SQLite (default) or MySQL 8.0+

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/YOUR_USERNAME/vote_system.git
cd vote_system
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

SQLite is configured by default. Ensure the database file exists:

```bash
touch database/database.sqlite
```

For MySQL, update `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=voting_system
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrate and seed

```bash
php artisan migrate
php artisan db:seed
```

### 5. Start the development server

```bash
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000).

## Default Credentials

After seeding:

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@example.com` | `password` |
| Voter | Seeded voter accounts | `password` |

New registrations are assigned the **voter** role and must log in after signing up.

## Usage

### Admins

1. Log in at `/login` with admin credentials
2. Open the dashboard for statistics
3. Create elections and add candidates
4. Activate elections when ready
5. View analytics at `/admin/analytics`
6. Export reports from each election page

### Voters

1. Register at `/register` or log in at `/login`
2. View available elections on the dashboard
3. Cast a vote on active elections
4. View results for completed elections

## API Authentication

All protected endpoints require a Bearer token from `POST /api/login`.

### Public endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/health` | Health check |
| POST | `/api/login` | Obtain access token |
| GET | `/api/elections` | List elections |
| GET | `/api/elections/{id}` | Get election |
| GET | `/api/elections/{id}/candidates` | List candidates |
| GET | `/api/elections/{id}/results` | Get results |
| GET | `/api/candidates` | List all candidates |

### Authenticated endpoints (Bearer token required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/me` | Current user profile |
| POST | `/api/logout` | Revoke current token |
| POST | `/api/votes` | Cast a vote |

### Admin endpoints (admin role + Bearer token)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/admin/elections` | Create election |
| PUT | `/api/admin/elections/{id}` | Update election |
| DELETE | `/api/admin/elections/{id}` | Delete election |
| POST | `/api/admin/elections/{id}/candidates` | Add candidate |
| PUT | `/api/admin/candidates/{id}` | Update candidate |
| DELETE | `/api/admin/candidates/{id}` | Delete candidate |

### Example

```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Cast a vote
curl -X POST http://localhost:8000/api/votes \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"election_id":1,"candidate_id":2}'

# Logout
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## Security

- Passwords hashed with bcrypt
- CSRF protection on web forms
- Session-based web auth with optional "Remember me"
- Sanctum token auth for API
- `EnsureUserIsAdmin` middleware on web admin routes
- `EnsureApiUserIsAdmin` middleware on API admin routes
- Registration restricted to voter role (admins created via seeder or database)

## GitHub Actions & Pages

This repository includes:

- **CI** (`.github/workflows/ci.yml`) — Runs tests on push/PR
- **GitHub Pages** (`.github/workflows/pages.yml`) — Deploys `docs/` as project documentation

### Enable GitHub Pages

1. Push code to GitHub
2. Go to **Settings → Pages**
3. Set source to **GitHub Actions**
4. The workflow deploys `docs/index.html` automatically

> **Note:** GitHub Pages serves static documentation only. The Laravel app requires a PHP host (Render, Railway, shared hosting, VPS, etc.).

### PHP deployment (recommended hosts)

- [Render](https://render.com)
- [Railway](https://railway.app)
- [Laravel Forge](https://forge.laravel.com)
- Any VPS with PHP 8.3, Composer, and a web server

Deployment checklist:

```bash
composer install --optimize-autoloader --no-dev
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Set `APP_ENV=production`, `APP_DEBUG=false`, and configure your database in `.env`.

## Development Team

| Name | Role |
|------|------|
| Team Lead | Project Lead & Backend Developer |
| Frontend Developer | UI/UX & Frontend Development |
| Backend Developer | API & Database Design |
| QA Engineer | Testing & Quality Assurance |

Update team member names in `config/contributors.php`. The home page displays the contributors section automatically.

## Running Tests

```bash
php artisan test
```

Or via Composer:

```bash
composer test
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/          # Login, registration
│   │   ├── Api/           # REST API + AuthController
│   │   └── ...            # Web controllers
│   └── Middleware/
│       ├── EnsureUserIsAdmin.php
│       └── EnsureApiUserIsAdmin.php
├── Models/
config/
├── contributors.php       # Team members for UI
docs/
├── index.html             # GitHub Pages documentation site
resources/views/           # Blade templates
routes/
├── web.php
└── api.php
.github/workflows/
├── ci.yml
└── pages.yml
```

## License

This project is open source and available under the [MIT License](https://opensource.org/licenses/MIT).

---

**Version:** 1.1.0  
**Last Updated:** August 2026
