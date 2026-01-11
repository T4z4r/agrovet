<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionMiddleware
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Skip subscription check for superadmin
        if ($user->hasRole('superadmin')) {
            return $next($request);
        }

        if (!$this->subscriptionService->isSubscriptionActive($user)) {
            return response()->json([
                'message' => 'Subscription expired. Please renew your subscription to continue using the service.',
                'remaining_days' => $this->subscriptionService->getRemainingDays($user)
            ], 403);
        }

        return $next($request);
    }
}
