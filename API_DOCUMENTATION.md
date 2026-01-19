# Apex API Documentation

This document describes the API endpoints for the Apex application.

## Public Endpoints

### Get About Information
- **Method**: GET
- **Endpoint**: `/api/about`
- **Description**: Get application about information
- **Response**:
  ```json
  {
    "success": true,
    "data": {
      "id": 1,
      "title": "About Apex",
      "content": "...",
      "created_at": "...",
      "updated_at": "..."
    },
    "message": "About retrieved successfully"
  }
  ```

### Get Contacts
- **Method**: GET
- **Endpoint**: `/api/contacts`
- **Description**: Get application contact information
- **Response**:
  ```json
  {
    "success": true,
    "data": [
      {
        "id": 1,
        "type": "phone",
        "value": "+254 700 123 456",
        "created_at": "...",
        "updated_at": "..."
      },
      ...
    ],
    "message": "Contacts retrieved successfully"
  }
  ```

## Authentication

All API requests require authentication except for registration and login. Use the `Authorization: Bearer <token>` header for authenticated requests.

### Register User
- **Method**: POST
- **Endpoint**: `/api/register`
- **Description**: Register a new user
- **Request Body**:
  ```json
  {
    "name": "string (required)",
    "email": "string (required, unique)",
    "password": "string (required, confirmed)",
    "password_confirmation": "string (required)",
    "role": "admin|owner|seller (required)"
  }
  ```
- **Response**:
  ```json
  {
    "success": true,
    "data": {
      "user": {...},
      "token": "string"
    },
    "message": "User registered successfully"
  }
  ```

### Login User (OTP-based)
- **Method**: POST
- **Endpoint**: `/api/login`
- **Description**: Authenticate user and send OTP
- **Request Body**:
  ```json
  {
    "email": "string (required)",
    "password": "string (required)"
  }
  ```
- **Success Response**:
  ```json
  {
    "success": true,
    "message": "OTP sent to your email. Please verify to complete login."
  }
  ```
- **Error Response** (401):
  ```json
  {
    "success": false,
    "message": "Invalid credentials"
  }
  ```

### Verify OTP
- **Method**: POST
- **Endpoint**: `/api/verify-otp`
- **Description**: Verify OTP code and complete login
- **Request Body**:
  ```json
  {
    "email": "string (required)",
    "otp_code": "string (required, 6 digits)"
  }
  ```
- **Success Response**:
  ```json
  {
    "success": true,
    "data": {
      "user": {...},
      "token": "string"
    },
    "message": "OTP verified successfully. Logged in."
  }
  ```
- **Error Response** (401):
  ```json
  {
    "success": false,
    "message": "Invalid or expired OTP"
  }
  ```

### Resend OTP
- **Method**: POST
- **Endpoint**: `/api/resend-otp`
- **Description**: Resend OTP code for login
- **Request Body**:
  ```json
  {
    "email": "string (required)"
  }
  ```
- **Success Response**:
  ```json
  {
    "success": true,
    "message": "New OTP sent to your email."
  }
  ```
- **Error Response** (429):
  ```json
  {
    "success": false,
    "message": "OTP already sent. Please wait before requesting a new one."
  }
  ```

### Forgot Password
- **Method**: POST
- **Endpoint**: `/api/forgot-password`
- **Description**: Send password reset OTP to user's email
- **Request Body**:
  ```json
  {
    "email": "string (required, email)"
  }
  ```
- **Success Response**:
  ```json
  {
    "success": true,
    "message": "Password reset OTP sent to your email."
  }
  ```
- **Error Response** (404):
  ```json
  {
    "success": false,
    "message": "User not found"
  }
  ```
- **Error Response** (429):
  ```json
  {
    "success": false,
    "message": "OTP already sent. Please wait before requesting a new one."
  }
  ```

### Reset Password
- **Method**: POST
- **Endpoint**: `/api/reset-password`
- **Description**: Reset user password using OTP
- **Request Body**:
  ```json
  {
    "email": "string (required, email)",
    "otp_code": "string (required, 6 digits)",
    "password": "string (required, min:8, confirmed)",
    "password_confirmation": "string (required)"
  }
  ```
- **Success Response**:
  ```json
  {
    "success": true,
    "message": "Password reset successfully."
  }
  ```
- **Error Response** (404):
  ```json
  {
    "success": false,
    "message": "User not found"
  }
  ```
- **Error Response** (401):
  ```json
  {
    "success": false,
    "message": "Invalid or expired OTP"
  }
  ```

### Get Current User
- **Method**: GET
- **Endpoint**: `/api/me`
- **Description**: Get authenticated user details
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "User data retrieved successfully"
  }
  ```

### Logout User
- **Method**: POST
- **Endpoint**: `/api/logout`
- **Description**: Logout current user
- **Response**:
  ```json
  {
    "success": true,
    "message": "Logged out successfully"
  }
  ```

## OTP Management

The OTP (One-Time Password) system provides secure verification for various purposes including login, email verification, password reset, and additional security checks.

### Send OTP
- **Method**: POST
- **Endpoint**: `/api/otp/send`
- **Description**: Send OTP code for a specific purpose
- **Request Body**:
 ```json
 {
   "email": "string (required)",
   "purpose": "login|email_verification|password_reset|security (required)"
 }
 ```
- **Success Response**:
 ```json
 {
   "success": true,
   "message": "OTP sent successfully to your email."
 }
 ```
- **Error Response** (404):
 ```json
 {
   "success": false,
   "message": "User not found"
 }
 ```
- **Error Response** (429):
 ```json
 {
   "success": false,
   "message": "OTP already sent. Please check your email."
 }
 ```

### Verify OTP
- **Method**: POST
- **Endpoint**: `/api/otp/verify`
- **Description**: Verify OTP code for a specific purpose
- **Request Body**:
 ```json
 {
   "email": "string (required)",
   "otp_code": "string (required, 6 digits)",
   "purpose": "login|email_verification|password_reset|security (required)"
 }
 ```
- **Success Response**:
 ```json
 {
   "success": true,
   "message": "OTP verified successfully.",
   "data": {
     "user": {...},
     "purpose": "string"
   }
 }
 ```
- **Error Response** (404):
 ```json
 {
   "success": false,
   "message": "User not found"
 }
 ```
- **Error Response** (401):
 ```json
 {
   "success": false,
   "message": "Invalid or expired OTP"
 }
 ```

### Check OTP Status
- **Method**: POST
- **Endpoint**: `/api/otp/status`
- **Description**: Check if user has a valid OTP and get remaining time
- **Request Body**:
 ```json
 {
   "email": "string (required)",
   "purpose": "login|email_verification|password_reset|security (required)"
 }
 ```
- **Success Response**:
 ```json
 {
   "success": true,
   "data": {
     "has_valid_otp": true,
     "remaining_minutes": 8
   }
 }
 ```
- **Error Response** (404):
 ```json
 {
   "success": false,
   "message": "User not found"
 }
 ```

### Clear OTP
- **Method**: POST
- **Endpoint**: `/api/otp/clear`
- **Description**: Clear OTP for a user (admin/utility function)
- **Request Body**:
 ```json
 {
   "email": "string (required)",
   "purpose": "login|email_verification|password_reset|security (required)"
 }
 ```
- **Success Response**:
 ```json
 {
   "success": true,
   "message": "OTP cleared successfully."
 }
 ```
- **Error Response** (404):
 ```json
 {
   "success": false,
   "message": "User not found"
 }
 ```

### OTP Purposes
- **login**: User authentication (used by login flow)
- **email_verification**: Email address verification
- **password_reset**: Password reset verification
- **security**: Additional security verification for sensitive operations

### OTP Features
- **6-digit codes**: Randomly generated numeric codes
- **10-minute expiration**: OTP codes expire after 10 minutes
- **Attempt limiting**: Maximum 3 verification attempts per OTP
- **Purpose isolation**: OTP codes are specific to their purpose
- **Email notifications**: OTP codes are sent via email with contextual messages
- **Cache storage**: OTP data stored in Laravel cache for performance

## Products

### List Products
- **Method**: GET
- **Endpoint**: `/api/products`
- **Description**: Get all products
- **Response**:
  ```json
  {
    "success": true,
    "data": [...],
    "message": "Products retrieved successfully"
  }
  ```

### Create Product
- **Method**: POST
- **Endpoint**: `/api/products`
- **Description**: Create a new product
- **Request Body**:
  ```json
  {
    "name": "string (required)",
    "unit": "string (required)",
    "category": "string (required)",
    "stock": "integer (required, min:0)",
    "cost_price": "numeric (required, min:0)",
    "selling_price": "numeric (required, min:0)",
    "minimum_quantity": "numeric (optional, min:0)",
    "barcode": "string (optional)"
  }
  ```
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Product created successfully"
  }
  ```

### Get Product
- **Method**: GET
- **Endpoint**: `/api/products/{id}`
- **Description**: Get a specific product
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Product retrieved successfully"
  }
  ```

### Update Product
- **Method**: PUT
- **Endpoint**: `/api/products/{id}`
- **Description**: Update a product
- **Request Body**: Same as create
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Product updated successfully"
  }
  ```

### Delete Product
- **Method**: DELETE
- **Endpoint**: `/api/products/{id}`
- **Description**: Delete a product
- **Response**:
  ```json
  {
    "success": true,
    "message": "Product deleted successfully"
  }
  ```

### Get Product by Barcode
- **Method**: GET
- **Endpoint**: `/api/products/barcode/{barcode}`
- **Description**: Get a product by its barcode
- **Success Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Product retrieved successfully"
  }
  ```
- **Error Response** (404):
  ```json
  {
    "success": false,
    "message": "Product not found"
  }
  ```

## Suppliers

### List Suppliers
- **Method**: GET
- **Endpoint**: `/api/suppliers`
- **Description**: Get all suppliers
- **Response**:
  ```json
  {
    "success": true,
    "data": [...],
    "message": "Suppliers retrieved successfully"
  }
  ```

### Create Supplier
- **Method**: POST
- **Endpoint**: `/api/suppliers`
- **Description**: Create a new supplier
- **Request Body**:
  ```json
  {
    "name": "string (required)",
    "contact_person": "string (optional)",
    "phone": "string (optional)",
    "email": "string (optional, email)",
    "address": "string (optional)"
  }
  ```
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Supplier created successfully"
  }
  ```

### Get Supplier
- **Method**: GET
- **Endpoint**: `/api/suppliers/{id}`
- **Description**: Get a specific supplier
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Supplier retrieved successfully"
  }
  ```

### Update Supplier
- **Method**: PUT
- **Endpoint**: `/api/suppliers/{id}`
- **Description**: Update a supplier
- **Request Body**: Same as create
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Supplier updated successfully"
  }
  ```

### Delete Supplier
- **Method**: DELETE
- **Endpoint**: `/api/suppliers/{id}`
- **Description**: Delete a supplier
- **Response**:
  ```json
  {
    "success": true,
    "message": "Supplier deleted successfully"
  }
  ```

## Stock Transactions

### List Stock Transactions
- **Method**: GET
- **Endpoint**: `/api/stock`
- **Description**: Get all stock transactions
- **Response**:
  ```json
  {
    "success": true,
    "data": [...],
    "message": "Stock transactions retrieved successfully"
  }
  ```

### Create Stock Transaction
- **Method**: POST
- **Endpoint**: `/api/stock`
- **Description**: Create a new stock transaction
- **Request Body**:
  ```json
  {
    "product_id": "integer (required, exists:products)",
    "type": "stock_in|stock_out|damage|return (required)",
    "quantity": "integer (required, min:1)",
    "supplier_id": "integer (optional, exists:suppliers)",
    "date": "date (required, YYYY-MM-DD)",
    "remarks": "string (optional)"
  }
  ```
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Stock transaction created successfully"
  }
  ```

### Get Stock Transaction
- **Method**: GET
- **Endpoint**: `/api/stock/{id}`
- **Description**: Get a specific stock transaction
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Stock transaction retrieved successfully"
  }
  ```

### Delete Stock Transaction
- **Method**: DELETE
- **Endpoint**: `/api/stock/{id}`
- **Description**: Delete a stock transaction
- **Response**:
  ```json
  {
    "success": true,
    "message": "Stock transaction deleted successfully"
  }
  ```

## Sales

### List Sales
- **Method**: GET
- **Endpoint**: `/api/sales`
- **Description**: Get all sales
- **Response**:
  ```json
  {
    "success": true,
    "data": [...],
    "message": "Sales retrieved successfully"
  }
  ```

### Create Sale
- **Method**: POST
- **Endpoint**: `/api/sales`
- **Description**: Create a new sale
- **Request Body**:
  ```json
  {
    "seller_id": "integer (required, exists:users)",
    "sale_date": "date (required, YYYY-MM-DD)",
    "items": "array (required, min:1)",
    "items.*.product_id": "integer (required, exists:products)",
    "items.*.quantity": "integer (required, min:1)",
    "items.*.price": "numeric (required, min:0)"
  }
  ```
- **Success Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Sale created successfully"
  }
  ```
- **Error Response** (422):
  ```json
  {
    "success": false,
    "message": "Insufficient stock for {product_name}"
  }
  ```

### Get Sale
- **Method**: GET
- **Endpoint**: `/api/sales/{id}`
- **Description**: Get a specific sale
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Sale retrieved successfully"
  }
  ```

### Download Receipt
- **Method**: GET
- **Endpoint**: `/api/sales/{id}/receipt`
- **Description**: Download PDF receipt for a sale
- **Response**: PDF file

## Expenses

### List Expenses
- **Method**: GET
- **Endpoint**: `/api/expenses`
- **Description**: Get all expenses
- **Response**:
  ```json
  {
    "success": true,
    "data": [...],
    "message": "Expenses retrieved successfully"
  }
  ```

### Create Expense
- **Method**: POST
- **Endpoint**: `/api/expenses`
- **Description**: Create a new expense
- **Request Body**:
  ```json
  {
    "category": "string (required)",
    "amount": "numeric (required, min:0)",
    "description": "string (optional)",
    "date": "date (required, YYYY-MM-DD)"
  }
  ```
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Expense created successfully"
  }
  ```

### Get Expense
- **Method**: GET
- **Endpoint**: `/api/expenses/{id}`
- **Description**: Get a specific expense
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Expense retrieved successfully"
  }
  ```

### Update Expense
- **Method**: PUT
- **Endpoint**: `/api/expenses/{id}`
- **Description**: Update an expense
- **Request Body**: Same as create
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Expense updated successfully"
  }
  ```

### Delete Expense
- **Method**: DELETE
- **Endpoint**: `/api/expenses/{id}`
- **Description**: Delete an expense
- **Response**:
  ```json
  {
    "success": true,
    "message": "Expense deleted successfully"
  }
  ```

## Reports

### Daily Report
- **Method**: GET
- **Endpoint**: `/api/reports/daily/{date}`
- **Description**: Get daily sales and expenses report for the specified date (YYYY-MM-DD)
- **Response**:
  ```json
  {
    "success": true,
    "data": {
      "sales": [...],
      "total_sales": "numeric",
      "expenses": [...],
      "total_expenses": "numeric"
    },
    "message": "Daily report retrieved successfully"
  }
  ```

### Daily Report PDF
- **Method**: GET
- **Endpoint**: `/api/reports/daily/{date}/pdf`
- **Description**: Download PDF report of daily sales and expenses for the specified date (YYYY-MM-DD)
- **Response**: PDF file

### Profit Report
- **Method**: GET
- **Endpoint**: `/api/reports/profit/{start}/{end}`
- **Description**: Get profit report between start and end dates (YYYY-MM-DD/YYYY-MM-DD) based on sale creation dates
- **Response**:
  ```json
  {
    "success": true,
    "data": {
      "revenue": "numeric",
      "cost": "numeric",
      "profit": "numeric"
    },
    "message": "Profit report retrieved successfully"
  }
  ```

### Dashboard Data
- **Method**: GET
- **Endpoint**: `/api/reports/dashboard`
- **Description**: Get dashboard statistics
- **Response**:
  ```json
  {
    "success": true,
    "data": {
      "total_products": "integer",
      "total_sales": "numeric",
      "total_expenses": "numeric",
      "today_sales": "numeric",
      "stock_value": "numeric",
      "low_stock_products_count": "integer"
    },
    "message": "Dashboard data retrieved successfully"
  }
  ```

### Seller Day Summary
- **Method**: GET
- **Endpoint**: `/api/reports/seller/day-summary/{date?}`
- **Description**: Get summary of authenticated seller's activities for the specified date (YYYY-MM-DD). If no date is provided, defaults to today.
- **Response**:
  ```json
  {
    "success": true,
    "data": {
      "date": "string (YYYY-MM-DD)",
      "sales": [...],
      "total_sales": "numeric",
      "expenses": [...],
      "total_expenses": "numeric",
      "stock_transactions": [...]
    },
    "message": "Seller day summary retrieved successfully"
  }
  ```

## Sellers (Owner Only)

### List Sellers
- **Method**: GET
- **Endpoint**: `/api/sellers`
- **Description**: Get all sellers (owner only)
- **Response**:
  ```json
  {
    "success": true,
    "data": [...],
    "message": "Sellers retrieved successfully"
  }
  ```

### Create Seller
- **Method**: POST
- **Endpoint**: `/api/sellers`
- **Description**: Create a new seller (owner only)
- **Request Body**:
  ```json
  {
    "name": "string (required)",
    "email": "string (required, unique)",
    "password": "string (required, min:6, confirmed)",
    "password_confirmation": "string (required)"
  }
  ```
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Seller created successfully"
  }
  ```

### Get Seller
- **Method**: GET
- **Endpoint**: `/api/sellers/{id}`
- **Description**: Get a specific seller (owner only)
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Seller retrieved successfully"
  }
  ```

### Update Seller
- **Method**: PUT
- **Endpoint**: `/api/sellers/{id}`
- **Description**: Update a seller (owner only)
- **Request Body**: Same as create, all fields optional
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Seller updated successfully"
  }
  ```

### Delete Seller
- **Method**: DELETE
- **Endpoint**: `/api/sellers/{id}`
- **Description**: Delete a seller (owner only)
- **Response**:
  ```json
  {
    "success": true,
    "message": "Seller deleted successfully"
  }
  ```

### Block/Unblock Seller
- **Method**: PATCH
- **Endpoint**: `/api/sellers/{id}/block`
- **Description**: Toggle block status of a seller (owner only)
- **Response**:
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Seller blocked/unblocked successfully"
  }
  ```

### Seller Report
- **Method**: GET
- **Endpoint**: `/api/sellers/{id}/report?start=YYYY-MM-DD&end=YYYY-MM-DD`
- **Description**: Get comprehensive report for a specific seller (owner only). Optional start and end dates for filtering.
- **Response**:
  ```json
  {
    "success": true,
    "data": {
      "seller": {...},
      "sales": [...],
      "total_sales": "numeric",
      "expenses": [...],
      "total_expenses": "numeric",
      "stock_transactions": [...]
    },
    "message": "Seller report retrieved successfully"
  }
  ```

## Shop Management

### Get Shop Details
- **Method**: GET
- **Endpoint**: `/api/shop`
- **Description**: Get the authenticated user's shop details
- **Authentication**: Required (Bearer token)
- **Response**:
  ```json
  {
    "id": 1,
    "name": "My Shop",
    "owner_id": 1,
    "location": "Nairobi",
    "created_at": "2025-12-05T22:25:04.000000Z",
    "updated_at": "2025-12-05T22:25:04.000000Z"
  }
  ```
- **Error Response** (404):
  ```json
  {
    "message": "Shop not found"
  }
  ```

### Update Shop Details
- **Method**: PUT
- **Endpoint**: `/api/shop`
- **Description**: Update the authenticated user's shop details
- **Authentication**: Required (Bearer token)
- **Request Body**:
  ```json
  {
    "name": "string (optional, max:255)",
    "location": "string (optional, max:255, nullable)"
  }
  ```
- **Success Response**:
  ```json
  {
    "id": 1,
    "name": "Updated Shop Name",
    "owner_id": 1,
    "location": "New Location",
    "created_at": "2025-12-05T22:25:04.000000Z",
    "updated_at": "2026-01-19T16:58:09.000000Z"
  }
  ```
- **Error Response** (404):
  ```json
  {
    "message": "Shop not found"
  }
  ```
- **Error Response** (422):
  ```json
  {
    "errors": {
      "name": ["The name may not be greater than 255 characters."]
    }
  }
  ```

## Usage Examples

### User Login Flow
```javascript
// 1. Login with credentials
const loginResponse = await fetch('/api/login', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'user@example.com',
    password: 'password123'
  })
});

// 2. Verify OTP
const verifyResponse = await fetch('/api/verify-otp', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'user@example.com',
    otp_code: '123456'
  })
});

// Use the token for authenticated requests
const token = verifyResponse.data.token;
```

### Password Reset Flow
```javascript
// 1. Request password reset OTP
await fetch('/api/otp/send', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'user@example.com',
    purpose: 'password_reset'
  })
});

// 2. Verify OTP and proceed with password reset
const verifyResponse = await fetch('/api/otp/verify', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'user@example.com',
    otp_code: '123456',
    purpose: 'password_reset'
  })
});

// 3. If verified, proceed with password update
if (verifyResponse.success) {
  // Update password logic here
}
```

### Check OTP Status
```javascript
const statusResponse = await fetch('/api/otp/status', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'user@example.com',
    purpose: 'login'
  })
});

if (statusResponse.data.has_valid_otp) {
  console.log(`${statusResponse.data.remaining_minutes} minutes left`);
}
```

## Error Handling

All API responses follow a consistent format. Successful responses include:
- `success`: true
- `data`: The requested data
- `message`: Success message

Error responses include:
- `success`: false
- `message`: Error description

### Common HTTP Status Codes
- **200**: Success
- **201**: Created
- **400**: Bad Request (validation errors)
- **401**: Unauthorized (invalid credentials, invalid/expired OTP)
- **404**: Not Found (resource or user not found)
- **422**: Unprocessable Entity (validation errors, insufficient stock)
- **429**: Too Many Requests (OTP rate limiting)
- **500**: Internal Server Error

### OTP-Specific Errors
- **Invalid or expired OTP** (401): OTP code is incorrect or has expired
- **OTP already sent** (429): User must wait before requesting new OTP
- **Maximum attempts exceeded** (401): Too many failed verification attempts

Validation errors are returned automatically by Laravel with appropriate HTTP status codes and detailed field-specific error messages.
