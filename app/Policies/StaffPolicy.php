<?php

namespace App\Policies;

use App\Models\User;

class StaffPolicy
{
    /**
     * Determine whether the user can view any staff.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('owner');
    }

    /**
     * Determine whether the user can view the staff member.
     */
    public function view(User $user, User $staff): bool
    {
        return $user->hasRole('owner') &&
               $user->shops()->where('id', $staff->shop_id)->exists() &&
               $staff->hasAnyRole(['seller', 'manager']);
    }

    /**
     * Determine whether the user can create staff members.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('owner');
    }

    /**
     * Determine whether the user can update the staff member.
     */
    public function update(User $user, User $staff): bool
    {
        return $user->hasRole('owner') &&
               $user->shops()->where('id', $staff->shop_id)->exists() &&
               $staff->hasAnyRole(['seller', 'manager']) &&
               $user->id !== $staff->id; // Cannot modify self
    }

    /**
     * Determine whether the user can delete the staff member.
     */
    public function delete(User $user, User $staff): bool
    {
        return $user->hasRole('owner') &&
               $user->shops()->where('id', $staff->shop_id)->exists() &&
               $staff->hasAnyRole(['seller', 'manager']) &&
               $user->id !== $staff->id; // Cannot delete self
    }

    /**
     * Determine whether the user can assign roles to staff.
     */
    public function assignRole(User $user, User $staff): bool
    {
        return $user->hasRole('owner') &&
               $user->shops()->where('id', $staff->shop_id)->exists() &&
               $staff->hasAnyRole(['seller', 'manager']) &&
               $user->id !== $staff->id; // Cannot modify self
    }
}