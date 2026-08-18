# Quick Start Guide

## Getting Started in 5 Minutes

### Prerequisites
- PHP 8.2+
- Composer
- MySQL/PostgreSQL
- Node.js & npm

### Step 1: Install Dependencies
```bash
composer install
npm install
```

### Step 2: Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=voting_system
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Setup Database
```bash
php artisan migrate
php artisan db:seed
```

### Step 4: Build & Run
```bash
npm run build
php artisan serve
```

Visit: `http://localhost:8000`

### Step 5: Login
**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

**Voter Account:** (created during seeding)
- Email: Any email from seeded voters
- Password: `password`

## Key Routes

### Admin Routes
- `/dashboard` - Admin dashboard with analytics
- `/elections` - Manage elections (create, edit, delete)
- `/elections/{id}/candidates` - Manage candidates
- `/admin/analytics` - System analytics and reports

### Voter Routes
- `/dashboard` - Voter dashboard with available elections
- `/elections/{id}/vote` - Cast vote
- `/elections/{id}/results` - View results
- `/elections/{id}/reports` - Export reports

### API Routes
- `GET /api/elections` - List elections
- `GET /api/candidates` - List candidates
- `GET /api/elections/{id}/results` - Get results
- `POST /api/votes` - Cast vote (requires token)

## Commands

```bash
# Run tests
php artisan test

# Clear cache
php artisan cache:clear

# Generate API documentation
php artisan scribe:generate

# Refresh database with fresh seed
php artisan migrate:refresh --seed

# Compile assets
npm run dev        # Development
npm run build      # Production
```

## Troubleshooting

**Issue: "Class not found" error**
```bash
composer dump-autoload
php artisan optimize
```

**Issue: Database connection error**
- Check `.env` database settings
- Ensure MySQL is running
- Create the database manually if needed

**Issue: Missing views or 404**
- Run `php artisan view:clear`
- Ensure all migration files exist

## File Structure

```
vote_system/
├── app/               # Application code
├── database/          # Migrations, factories, seeders
├── resources/views/   # Blade templates
├── routes/            # Web & API routes
├── public/            # Static assets
├── storage/           # User uploads, cache
└── tests/             # Test files
```

## Features Implemented

✅ User authentication (admin/voter roles)
✅ Election management (CRUD)
✅ Candidate management (CRUD with images)
✅ Real-time vote counting
✅ Election results dashboard
✅ Report generation (CSV, JSON, HTML)
✅ Admin analytics
✅ RESTful API
✅ Mobile responsive UI
✅ Role-based access control

## Next Steps

1. Customize branding in `layout.blade.php`
2. Add your election data
3. Deploy to hosting service
4. Configure email notifications (optional)
5. Set up SSL certificate

## Support

For issues, check:
- Laravel docs: https://laravel.com/docs
- Project README: See README.md
- Database schema: database/migrations/

---

Happy Voting! 🗳️
