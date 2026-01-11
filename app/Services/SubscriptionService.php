<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * Get the user's current active subscription
     */
    protected function activeSubscription(User $user): ?Subscription
    {
        return $user->subscriptions()
            ->where('status', 'active')
            ->latest('end_date')
            ->first();
    }

    /**
     * Check if the user's subscription is active and not expired
     */
    public function isSubscriptionActive(User $user): bool
    {
        $subscription = $this->activeSubscription($user);

        if (!$subscription || !$subscription->end_date) {
            return false;
        }

        return Carbon::parse($subscription->end_date)->isFuture();
    }

    /**
     * Get the remaining days for the user's active subscription
     */
    public function getRemainingDays(User $user): int
    {
        $subscription = $this->activeSubscription($user);

        if (!$subscription || !$subscription->end_date) {
            return 0;
        }

        $endDate = Carbon::parse($subscription->end_date);

        if ($endDate->isPast()) {
            return 0;
        }

        return max(0, now()->diffInDays($endDate));
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
        return $this->activeSubscription($user);
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

        if (
            !$subscription ||
            !$subscription->subscriptionPackage
        ) {
            return false;
        }

        return $subscription->subscriptionPackage
            ->features()
            ->where('name', $featureName)
            ->exists();
    }
}
