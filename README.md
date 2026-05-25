# Food Safety & Quality Assurance Monitoring Dashboard

Full-stack monitoring dashboard with a Laravel API backend and React frontend.

## Project Structure

```
Dashboard/
├── backend/          # Laravel API (Laravel 9 — PHP 8.2 compatible)
├── frontend/         # React + Vite + Tailwind
├── monitoring_db.sql # MySQL schema + seed reference
└── README.md
```

## Requirements

- PHP 8.1+ with Composer
- Node.js 18+
- MySQL 8+ (production) or SQLite (quick local dev)

## Backend Setup

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

### Option A: SQLite (quickest)

```bash
# In backend/.env set:
# DB_CONNECTION=sqlite
# (leave DB_DATABASE unset — Laravel uses database/database.sqlite)
# (comment out DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD mysql vars)

type nul > database\database.sqlite   # Windows (if file missing)
php artisan migrate:fresh --seed
php artisan serve
```

API base URL: `http://localhost:8000/api`

### Option B: MySQL

1. Create database `monitoring_db`
2. Import schema/seed:

```bash
mysql -u root -p monitoring_db < ../monitoring_db.sql
```

3. Configure `backend/.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monitoring_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

4. Run migrations (if not importing SQL):

```bash
php artisan migrate:fresh --seed
```

```bash
php artisan serve
```

### API Routes

| Method | Endpoint |
|--------|----------|
| GET | `/api/analytics` |
| apiResource | `/api/raw-material-logs` |
| apiResource | `/api/delivery-truck-logs` |
| apiResource | `/api/pest-control-logs` |
| apiResource | `/api/oil-temperature-logs` |
| apiResource | `/api/cleaning-logs` |
| apiResource | `/api/stock-management-logs` |

Each resource supports: `GET` (paginated 15/page), `POST`, `GET/{id}`, `PUT/{id}`, `DELETE/{id}`.

Verify routes:

```bash
php artisan route:list --path=api
curl http://localhost:8000/api/analytics
```

## Frontend Setup

```bash
cd frontend
npm install
cp .env.example .env
npm run dev
```

App URL: `http://localhost:5173`

Ensure `VITE_API_URL=http://localhost:8000/api` in `frontend/.env`.

Production build:

```bash
npm run build
```

## Monitoring Tables

| Table | Model | Controller | React Page |
|-------|-------|--------------|------------|
| `raw_material_logs` | `RawMaterialLog` | `RawMaterialLogController` | `RawMaterialLogsPage.jsx` |
| `delivery_truck_logs` | `DeliveryTruckLog` | `DeliveryTruckLogController` | `DeliveryTruckLogsPage.jsx` |
| `pest_control_logs` | `PestControlLog` | `PestControlLogController` | `PestControlLogsPage.jsx` |
| `oil_temperature_logs` | `OilTemperatureLog` | `OilTemperatureLogController` | `OilTemperatureLogsPage.jsx` |
| `cleaning_logs` | `CleaningLog` | `CleaningLogController` | `CleaningLogsPage.jsx` |
| `stock_management_logs` | `StockManagementLog` | `StockManagementLogController` | `StockManagementLogsPage.jsx` |

Home analytics: `src/pages/DashboardOverview.jsx`

## Notes

- **Laravel version**: Environment has PHP &lt; 8.3, so Laravel 9 was installed instead of Laravel 11. API structure matches Laravel 11 conventions (`routes/api.php`, resource controllers, form requests).
- CORS allows `http://localhost:5173` and `http://127.0.0.1:5173`.
- Seed data is in `MonitoringSeeder` and mirrored in `monitoring_db.sql`.
- API payloads use snake_case; React hooks/services pass snake_case to the API.
