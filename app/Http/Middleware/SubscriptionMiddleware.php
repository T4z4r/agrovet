<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionMiddleware
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Skip subscription check for superadmin
        if (method_exists($user, 'hasRole') && $user->hasRole('superadmin')) {
            return $next($request);
        }

        if (!$this->subscriptionService->isSubscriptionActive($user)) {
            return response()->json([
                'message' => 'Your subscription has expired. Please renew to continue.',
                'remaining_days' => $this->subscriptionService->getRemainingDays($user),
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
