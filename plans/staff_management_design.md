# Staff Management Architecture and Requirements Design

## Overview
This document outlines the design for staff management functionality in the Agrovet application. Staff management allows shop owners to manage users with 'seller' or 'manager' roles within their shops. The system leverages Spatie Laravel Permission for role-based access control.

## Existing System Context
- **Users**: Have roles (owner, seller, manager) via Spatie Permission
- **Shops**: Owned by users (owner_id), contain branches
- **Branches**: Belong to shops, users assigned to branches
- **Permissions**: 'manage staff' permission exists for managers and owners
- **Current User Management**: WebUserController handles user CRUD with shop ownership checks

## Functional Requirements

### Core Features
1. **View Staff**: List all staff (sellers and managers) in the owner's shops
2. **Add Staff**: Create new users with seller/manager roles assigned to owner's shops/branches
3. **Edit Staff**: Update staff details, roles, shop/branch assignments
4. **Remove Staff**: Deactivate or delete staff accounts
5. **Assign Roles**: Change roles between seller and manager for existing staff
6. **Staff Filtering**: Filter staff by shop, branch, role, status

### Business Rules
- Only users with 'owner' role can manage staff
- Staff can only be assigned to shops owned by the managing owner
- Staff roles limited to 'seller' and 'manager'
- Owners cannot modify their own roles or remove themselves
- Staff must be assigned to a shop and optionally a branch

## Technical Architecture

### Models
- **User**: Existing model with HasRoles trait
  - Relationships: assignedShop, branch, shops (owned)
  - Additional scope: `staff()` for filtering seller/manager roles

### Controllers
- **StaffController** (new)
  - `index()`: List staff with filtering
  - `create()`: Show form for new staff
  - `store()`: Create new staff user
  - `show()`: Display staff details
  - `edit()`: Show edit form
  - `update()`: Update staff details
  - `destroy()`: Deactivate/remove staff
  - `assignRole()`: Change staff role

### Views
- `resources/views/staff/index.blade.php`: Staff listing with filters
- `resources/views/staff/create.blade.php`: New staff form
- `resources/views/staff/edit.blade.php`: Edit staff form
- `resources/views/staff/show.blade.php`: Staff details

### Routes
```php
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::resource('staff', StaffController::class)->names('staff');
    Route::post('staff/{user}/assign-role', [StaffController::class, 'assignRole'])->name('staff.assignRole');
});
```

### Middleware/Authorization
- Role middleware: `role:owner`
- Policy: `StaffPolicy` for fine-grained authorization
- Permission check: `can('manage staff')` (though role check sufficient)

## Authorization Rules

### Access Control
- Only authenticated users with 'owner' role can access staff management
- Owners can only manage staff in shops they own
- Owners cannot manage other owners or modify their own staff status

### Data Scoping
- Staff queries filtered by `shop_id` in owner's shops
- Branch assignments validated against shop ownership
- Role assignments limited to 'seller' and 'manager'

## Data Flow

### View Staff List
1. Owner accesses `/staff`
2. Controller queries users with roles 'seller' or 'manager' in owner's shops
3. Applies filters (shop, branch, role, status)
4. Returns paginated results to view

### Add Staff
1. Owner submits create form with user details
2. Validate input and ownership
3. Create user with shop/branch assignment
4. Assign role via Spatie
5. Redirect with success message

### Edit Staff
1. Owner submits edit form
2. Validate ownership and role constraints
3. Update user details and role
4. Redirect with success message

### Remove Staff
1. Owner requests deletion
2. Soft delete or deactivate user
3. Update related records if needed
4. Redirect with success message

## Assumptions

1. **Single Shop Ownership**: Owners can own multiple shops, staff managed across all owned shops
2. **Role Hierarchy**: Owners > Managers > Sellers (managers have additional permissions)
3. **Branch Assignment**: Optional, staff can work across branches or be branch-specific
4. **User Activation**: Staff can be deactivated instead of deleted to preserve data integrity
5. **Email Uniqueness**: Emails remain unique across the system
6. **Permission Inheritance**: Roles define permissions, no direct permission assignment for staff
7. **Audit Trail**: All changes logged via existing auditing system
8. **OTP Verification**: New staff may need OTP verification for account activation

## Implementation Considerations

### Security
- CSRF protection on all forms
- Input validation and sanitization
- Ownership validation on all operations
- Rate limiting for bulk operations

### Performance
- Eager loading of relationships (shop, branch, roles)
- Pagination for large staff lists
- Database indexing on shop_id, branch_id, role assignments

### User Experience
- Clear error messages for authorization failures
- Confirmation dialogs for destructive actions
- Search and filter capabilities
- Responsive design for mobile access

### Testing
- Unit tests for controller methods
- Feature tests for authorization
- Integration tests for data flow
- Browser tests for UI interactions

## Migration/Changes Needed

### New Files
- `app/Http/Controllers/StaffController.php`
- `app/Policies/StaffPolicy.php`
- `resources/views/staff/*` (views)
- Routes in `routes/web.php`

### Modified Files
- Possibly update `WebUserController.php` to exclude staff or redirect to staff routes
- Update navigation menus to include staff management links

### Database
- No new tables required
- Existing user table and permission tables sufficient
- Consider adding indexes if performance issues arise

## Conclusion
This design provides a secure, scalable staff management system that integrates seamlessly with the existing Laravel application architecture. The use of Spatie Laravel Permission ensures consistent role-based access control, while ownership checks maintain data isolation between shop owners.