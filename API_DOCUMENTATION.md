# AgroVet API Documentation

This document describes the API endpoints for the AgroVet application.

## Authentication

All API requests require authentication except for registration and login. Use the `Authorization: Bearer <token>` header for authenticated requests.

### Register User
- **Method**: POST
- **Endpoint**: `/api/register`
- **Description**: Register a new user
- **Request Body**:
  ```json
  {
    "name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string",
    "role": "admin|owner|seller"
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

### Login User
- **Method**: POST
- **Endpoint**: `/api/login`
- **Description**: Authenticate user
- **Request Body**:
  ```json
  {
    "email": "string",
    "password": "string"
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
    "message": "User logged in successfully"
  }
  ```
- **Error Response** (401):
  ```json
  {
    "success": false,
    "message": "Invalid credentials"
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
    "name": "string",
    "unit": "string",
    "category": "string",
    "stock": "integer",
    "cost_price": "integer",
    "selling_price": "integer"
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
    "name": "string",
    "contact_person": "string (optional)",
    "phone": "string (optional)",
    "email": "string (optional)",
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
    "product_id": "integer",
    "type": "stock_in|stock_out|damage|return",
    "quantity": "integer",
    "supplier_id": "integer (optional)",
    "date": "date",
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
    "seller_id": "integer",
    "sale_date": "date",
    "items": [
      {
        "product_id": "integer",
        "quantity": "integer",
        "price": "integer"
      }
    ]
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
    "category": "string",
    "amount": "integer",
    "description": "string (optional)",
    "date": "date"
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
- **Description**: Get daily sales and expenses report
- **Response**:
  ```json
  {
    "success": true,
    "data": {
      "sales": [...],
      "total_sales": "integer",
      "expenses": [...],
      "total_expenses": "integer"
    },
    "message": "Daily report retrieved successfully"
  }
  ```

### Profit Report
- **Method**: GET
- **Endpoint**: `/api/reports/profit/{start}/{end}`
- **Description**: Get profit report between dates
- **Response**:
  ```json
  {
    "success": true,
    "data": {
      "revenue": "integer",
      "cost": "integer",
      "profit": "integer"
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
      "total_sales": "integer",
      "total_expenses": "integer",
      "today_sales": "integer",
      "stock_value": "integer"
    },
    "message": "Dashboard data retrieved successfully"
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

Validation errors are returned automatically by Laravel with appropriate HTTP status codes.
