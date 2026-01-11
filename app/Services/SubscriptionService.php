<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * Check if the user's subscription is active and not expired
     */
    public function isSubscriptionActive(User $user): bool
    {
        $subscription = $user->subscriptions()->where('status', 'active')->latest()->first();

        if (!$subscription) {
            return false;
        }

        return $subscription->end_date->isFuture();
    }

    /**
     * Get the remaining days for the user's active subscription
     */
    public function getRemainingDays(User $user): int
    {
        $subscription = $user->subscriptions()->where('status', 'active')->latest()->first();

        if (!$subscription) {
            return 0;
        }

        if ($subscription->end_date->isPast()) {
            return 0;
        }

        return now()->diffInDays($subscription->end_date, false);
    }

    /**
     * Check if the user's subscription has expired
     */
    public function isSubscriptionExpired(User $user): bool
    {
        return !$this->isSubscriptionActive($user);
    }

    /**
     * Get the current active subscription for the user
     */
    public function getCurrentSubscription(User $user): ?Subscription
    {
        return $user->subscriptions()->where('status', 'active')->latest()->first();
    }

    /**
     * Check if user can access a feature based on subscription
     */
    public function canAccessFeature(User $user, string $featureName): bool
    {
        if (!$this->isSubscriptionActive($user)) {
            return false;
        }

        $subscription = $this->getCurrentSubscription($user);
        if (!$subscription) {
            return false;
        }

        // Check if the subscription package includes the feature
        return $subscription->subscriptionPackage->features()->where('name', $featureName)->exists();
    }
}