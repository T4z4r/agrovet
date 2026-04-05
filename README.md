# Apex — Multi-Tenant Retail Shop Management System

A full-stack Laravel application for managing retail shop operations, including inventory, point-of-sale, sales tracking, supplier management, expense tracking, and financial reporting. Built with a multi-tenant architecture supporting multiple shops and branches, with both a web dashboard and a RESTful API.

---

## Features

- **Point-of-Sale (POS):** Browser-based terminal with product grid, multi-item cart, payment method selection, atomic stock deduction, and printable receipts.
- **Inventory Management:** Products with stock tracking, cost/selling prices, barcode support, photo upload, category assignment, and minimum quantity alerts.
- **Stock Transactions:** Record `stock_in`, `stock_out`, `damage`, and `return` movements — each automatically adjusts live stock levels.
- **Sales Tracking:** Full sales history with per-item breakdown, seller attribution, and PDF receipt generation.
- **Supplier Management:** Supplier records with contact details and a dedicated supplier debt tracker.
- **Expense Tracking:** Record and categorise shop/branch expenses.
- **Reporting:** Daily sales/expense reports, profit reports (revenue vs. cost over a date range), dashboard summary stats, per-seller daily summaries, and PDF export.
- **Multi-Tenancy:** Every data record is scoped to a `shop_id` and optionally a `branch_id`. Non-superadmin users only see their own shop's data.
- **Common Product Catalog:** Superadmin-managed global catalog of 100+ pre-defined products across 26 categories. Shop owners can bulk-add products from this catalog in one action.
- **Product Import / Export:** Bulk product import via CSV/Excel (with error reporting), downloadable import template, and product export to Excel.
- **Subscription System:** Four tiers — Free, Basic, Pro, Enterprise — with feature flags and payment tracking.
- **User & Role Management:** Role-based access control (RBAC) via Spatie Laravel Permission. Roles: `superadmin`, `owner`, `manager`, `seller`. Owners manage their own staff and assign roles.
- **Audit Trail:** Full model change history on all major entities via `owen-it/laravel-auditing`.
- **OTP Security:** Purpose-specific 6-digit OTPs (login, email verification, password reset, security) delivered via email. API login is OTP-gated.
- **Guides System:** Admins upload documentation/PDF guides targeted by role and language.
- **Multilingual:** English and Swahili (`sw`) via session-based locale switching.

---

## Application Roles

| Role | Access Summary |
|---|---|
| `superadmin` | Full system access: admin panel, all shops, subscription management, global product catalog, audit log, table management |
| `owner` | Full control over their shop: products, branches, staff, sales, expenses, subscriptions, reports |
| `manager` | View and create/edit products, suppliers, sales, expenses, and users within their shop |
| `seller` | View products/suppliers, create sales and expenses, view their own reports |

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12, PHP 8.2+ |
| API Auth | Laravel Sanctum 4.x |
| RBAC | Spatie Laravel Permission 6.x |
| Audit | owen-it/laravel-auditing 14.x |
| Excel / CSV | maatwebsite/excel 3.x |
| PDF | barryvdh/laravel-dompdf 3.x |
| Frontend | Blade, Bootstrap (Sneat Admin Theme), Highcharts.js, Boxicons |
| Build | Vite, Tailwind CSS |
| Database | MySQL (production), SQLite (development) |
| Queue | Laravel Queue |

---

## Getting Started

### Requirements

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL or SQLite

### Installation

```bash
git clone <repo-url>
cd agrovet

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Configure your database credentials in `.env`, then:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

The seeder creates four default accounts (all passwords: `password`):

| Email | Role |
|---|---|
| superadmin@example.com | superadmin |
| owner@example.com | owner |
| manager@example.com | manager |
| seller@example.com | seller |

A sample shop ("Sample Shop", Nairobi) with two branches and a Free subscription is created for the owner account.

---

## Web Dashboard Routes

| Path | Description |
|---|---|
| `/login` | Login page |
| `/dashboard` | Role-aware dashboard with 30-day sales/expenses chart |
| `/pos` | POS terminal |
| `/products` | Product management (CRUD, import, export, bulk add from catalog) |
| `/sales` | Sales history and receipt printing |
| `/stock-transactions` | Stock movement log |
| `/suppliers` | Supplier management |
| `/supplier-debts` | Supplier debt tracking |
| `/expenses` | Expense management |
| `/reports` | Daily, profit, and seller reports |
| `/staff` | Owner staff management and role assignment |
| `/users` | Admin user management |
| `/shops` | Shop management |
| `/branches` | Branch management |
| `/admin` | Superadmin panel (table stats, OTP-gated table clear) |
| `/admin/subscription-packages` | Subscription tier management |
| `/admin/subscriptions` | Subscription records |
| `/admin/audits` | Audit log |
| `/admin/guides` | Guide upload and management |
| `/superadmin/common-categories` | Global product category management |
| `/superadmin/common-products` | Global product catalog management |
| `/lang/{locale}` | Switch language (`en` or `sw`) |

---

## API Reference

Base URL: `/api`  
Authentication: `Authorization: Bearer <sanctum_token>`

### Auth (public)

| Method | Endpoint | Description |
|---|---|---|
| POST | `/register` | Register a new owner (auto-creates a shop) |
| POST | `/login` | Initiate login — sends OTP to email |
| POST | `/verify-otp` | Verify OTP and receive API token |
| POST | `/resend-otp` | Resend login OTP |
| POST | `/forgot-password` | Send password-reset OTP |
| POST | `/reset-password` | Reset password using OTP |

### Authenticated Endpoints

| Category | Endpoints |
|---|---|
| Session | `GET /me`, `POST /logout` |
| Products | CRUD `/products`, `GET /products/barcode/{barcode}` |
| Suppliers | CRUD `/suppliers` |
| Stock | CRUD `/stock` |
| Sales | `GET/POST /sales`, `GET /sales/{id}`, `DELETE /sales/{id}`, `GET /sales/{id}/receipt` (PDF) |
| Expenses | CRUD `/expenses` |
| Reports | `GET /reports/daily/{date}`, `GET /reports/daily/{date}/pdf`, `GET /reports/profit/{start}/{end}`, `GET /reports/dashboard`, `GET /reports/seller/day-summary/{date?}` |
| Sellers | CRUD `/sellers`, `PATCH /sellers/{id}/block`, `GET /sellers/{id}/report` |
| Subscriptions | `GET /subscription-packages`, `GET /subscription/current`, `POST /subscription/subscribe` |
| Shop | `GET /shop`, `PUT /shop` |
| Guides | CRUD `/guides`, `GET /guides/{id}/download` |

---

## Subscription Tiers

| Package | Price | Duration |
|---|---|---|
| Free | KES 0 | 1 month |
| Basic | KES 5,000 | 1 month |
| Pro | KES 15,000 | 3 months |
| Enterprise | KES 50,000 | 12 months |

---

## License

This project is proprietary software. All rights reserved.
