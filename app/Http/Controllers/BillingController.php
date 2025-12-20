<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * Show billing dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $plans = SubscriptionPlan::active()->get();
        // $paymentMethods = $user->paymentMethods(); // If we want to list saved cards
        
        return view('billing.index', compact('user', 'plans'));
    }

    /**
     * Subscribe to a plan.
     */
    public function subscribe(Request $request, SubscriptionPlan $plan)
    {
        $user = Auth::user();
        
        // Ensure user is not already subscribed to this plan
        if ($user->subscribed('default')) {
             // Handle switch logic or error
             // For simple MVP: Swap
             $user->subscription('default')->swap($plan->stripe_plan_id);
             return redirect()->route('billing.index')->with('success', 'Plano alterado com sucesso.');
        }

        // Initialize checkout
        return $user->newSubscription('default', $plan->stripe_plan_id)
            ->checkout([
                'success_url' => route('billing.index', ['success' => 'true']),
                'cancel_url' => route('billing.index', ['cancel' => 'true']),
            ]);
    }

    /**
     * Cancel subscription.
     */
    public function cancel()
    {
        Auth::user()->subscription('default')->cancel();
        return redirect()->route('billing.index')->with('success', 'Assinatura cancelada. Você ainda tem acesso até o fim do período.');
    }

    /**
     * Resume subscription.
     */
    public function resume()
    {
        Auth::user()->subscription('default')->resume();
        return redirect()->route('billing.index')->with('success', 'Assinatura reativada!');
    }

    /**
     * Redirect to Stripe Customer Portal.
     */
    public function portal()
    {
        return Auth::user()->redirectToBillingPortal(route('billing.index'));
    }
}
