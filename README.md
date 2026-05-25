# Ilocos Food Products — Sanitation Standard Operating Procedures (SSOP)

Full-stack SSOP dashboard for **Ilocos Food Products** (Taleb, Bantay, Ilocos Sur) with a Laravel API backend and React frontend. Log tables are normalized to **3NF** with reference tables for users, suppliers, and products.

## Project Structure

```
Dashboard/
├── backend/          # Laravel API (Laravel 9 — PHP 8.2 compatible)
├── frontend/         # React + Vite + Tailwind
├── monitoring_db.sql # MySQL 3NF schema + seed reference
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

## 3NF Schema

### Reference tables

| Table | Columns | Purpose |
|-------|---------|---------|
| `users` | `id`, `full_name`, `initials`, `role` | QC inspectors, operators, QA staff |
| `suppliers` | `id`, `name`, `contact_info` | Raw material suppliers |
| `products` | `id`, `name`, `category` | Finished goods for stock logs |

### Log tables (foreign keys)

| Table | FK columns |
|-------|------------|
| `raw_material_logs` | `supplier_id`, `qc_inspector_id`, `received_by_id` |
| `delivery_truck_logs` | `checked_by_id` (driver name stays as text) |
| `pest_control_logs` | `inspector_id`, `verified_by_qa_id` (nullable) |
| `oil_temperature_logs` | `operator_id`, `verified_by_qa_id` (nullable) |
| `cleaning_logs` | `performed_by_id`, `checked_by_id` (nullable) |
| `stock_management_logs` | `checked_by_id`, `product_id` |

`inspector_initials` and duplicate name VARCHAR columns were removed; initials live on `users.initials`.

## API Routes

| Method | Endpoint |
|--------|----------|
| GET | `/api/analytics` |
| GET | `/api/users` |
| GET | `/api/suppliers` |
| GET | `/api/products` |
| apiResource | `/api/raw-material-logs` |
| apiResource | `/api/delivery-truck-logs` |
| apiResource | `/api/pest-control-logs` |
| apiResource | `/api/oil-temperature-logs` |
| apiResource | `/api/cleaning-logs` |
| apiResource | `/api/stock-management-logs` |

Each log resource supports: `GET` (paginated 15/page, eager-loaded relations), `POST`, `GET/{id}`, `PUT/{id}`, `DELETE/{id}`.

Verify routes:

```bash
php artisan route:list --path=api
curl http://localhost:8000/api/analytics
curl http://localhost:8000/api/users
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

Forms use dropdowns (`*_id`) populated from reference endpoints via `useReferenceData()`.

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

## Seeding

`php artisan migrate:fresh --seed` runs `MonitoringSeeder` via factories:

| Table | Count |
|-------|-------|
| `users` | 10 (mixed roles: QA, QC_INSPECTOR, OPERATOR, WAREHOUSE, PEST_INSPECTOR) |
| `suppliers` | 10 |
| `products` | 20 |
| Each log table | 50 |

**Total:** 340 rows minimum. Factories live in `backend/database/factories/`.

## API performance

- Log `index` / `show` use `HandlesMonitoringCrud` with `RELATIONS` eager loads and `paginate(15)` (no N+1 on list/detail).
- `AnalyticsController` uses aggregate queries and grouped date counts instead of per-day loops.

## Notes

- **Laravel version**: Environment has PHP &lt; 8.3, so Laravel 9 was installed instead of Laravel 11. API structure matches Laravel 11 conventions (`routes/api.php`, resource controllers, form requests).
- **Users table**: Simplified for SSOP reference data (no email/password); not used for authentication in this dashboard.
- CORS allows `http://localhost:5173` and `http://127.0.0.1:5173`.
- API payloads use snake_case; React hooks/services pass snake_case `*_id` fields to the API.
