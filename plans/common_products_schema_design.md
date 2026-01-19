# Database Schema Design for Common Categories and Common Products

## Overview

This design introduces two new tables: `common_categories` and `common_products`. These tables serve as a centralized repository for product categories and product templates managed by superadmins. Shop owners can select from these common products to quickly add standardized products to their shops with default values.

## Existing Tables Integration

The existing `products` table has the following relevant fields:
- `id` (primary key)
- `name` (string)
- `unit` (string)
- `stock` (integer, default 0)
- `cost_price` (decimal 12,2)
- `selling_price` (decimal 12,2)
- `category` (string, nullable)
- `minimum_quantity` (double, default 0.00)
- `barcode` (string, nullable)
- `shop_id` (foreign key to shops, nullable)
- `photo` (string, nullable)
- `branch_id` (foreign key to branches, nullable)
- `created_at`, `updated_at`

The `shops` table:
- `id`
- `name`
- `owner_id` (foreign to users)
- `location` (nullable)
- `created_at`, `updated_at`

## New Tables

### common_categories

This table stores common categories managed by superadmins.

**Fields:**

- `id`: unsignedBigInteger, primary key, auto increment
- `name`: varchar(255), not null, unique
- `description`: text, nullable
- `is_active`: boolean, default true
- `created_at`: timestamp, nullable
- `updated_at`: timestamp, nullable

**Constraints:**
- Unique constraint on `name`

**Relationships:**
- One-to-many with `common_products` (via `common_category_id`)

### common_products

This table stores product templates with default values.

**Fields:**

- `id`: unsignedBigInteger, primary key, auto increment
- `name`: varchar(255), not null
- `unit`: varchar(50), not null
- `default_cost_price`: decimal(12,2), nullable
- `default_selling_price`: decimal(12,2), nullable
- `common_category_id`: unsignedBigInteger, not null, foreign key to `common_categories.id` on delete cascade
- `default_minimum_quantity`: double, default 0.00
- `barcode`: varchar(255), nullable
- `photo`: varchar(255), nullable
- `description`: text, nullable
- `is_active`: boolean, default true
- `created_at`: timestamp, nullable
- `updated_at`: timestamp, nullable

**Constraints:**
- Foreign key constraint on `common_category_id` referencing `common_categories.id` with cascade delete

**Relationships:**
- Many-to-one with `common_categories` (via `common_category_id`)

## How Common Products Serve as Templates

Common products act as predefined templates that shop owners can select to add products to their shops. When a shop owner selects a common product:

1. A new record is created in the `products` table with default values copied from the `common_products` record.
2. The `category` field in `products` is set to the `name` of the associated `common_categories` record.
3. Shop-specific fields like `shop_id`, `stock`, and `branch_id` are set appropriately.
4. The shop owner can then customize the product (e.g., adjust prices, stock) as needed.

This allows for quick setup of common products across shops while maintaining flexibility for customization.

## Integration with Existing Products Table

- The `products.category` field remains a string and is populated from `common_categories.name` when adding from templates.
- To maintain traceability, consider adding a `common_product_id` field to the `products` table (nullable foreign key to `common_products.id`) in a future migration. This would allow tracking which products originated from templates and enable updates if templates change.
- Existing products without a common product link can still be managed independently.

## Superadmin Management

Superadmins have full CRUD access to `common_categories` and `common_products` tables, allowing them to:
- Create, update, deactivate categories and products.
- Ensure consistency and standardization across the platform.

## Shop Owner Selection

Shop owners can:
- View active common products and categories.
- Select products to add to their shop, which populates the `products` table with defaults.
- Customize added products as needed.

This design supports scalability and standardization while allowing shop-level customization.