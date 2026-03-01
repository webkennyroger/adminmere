<?php

namespace App\Livewire\Plans;

use App\Models\SubscriptionPlan;
use Livewire\Component;

class PlanIndex extends Component
{
    public $showModal = false;

    public $isEditMode = false;

    public $confirmingDeletion = false;

    public $planToDelete;

    // Form fields
    public $planId;

    public $name;

    public $price;

    public $stripe_plan_id;

    public $billing_period = 'monthly';

    public $features;

    public $is_active = true;

    protected $rules = [
        'name' => 'required',
        'stripe_plan_id' => 'required', // unique validation handled manually for updates
        'price' => 'required|integer',
        'billing_period' => 'required|in:monthly,yearly',
        'features' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $plans = SubscriptionPlan::all();

        return view('livewire.plans.plan-index', compact('plans'));
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['planId', 'name', 'price', 'stripe_plan_id', 'billing_period', 'features', 'is_active']);
        $this->is_active = true;
        $this->billing_period = 'monthly';
        $this->isEditMode = false;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'stripe_plan_id' => 'required|unique:subscription_plans,stripe_plan_id',
            'price' => 'required|integer',
            'billing_period' => 'required|in:monthly,yearly',
            'features' => 'nullable|string',
        ]);

        $slug = \Str::slug($this->name.'-'.$this->billing_period);

        SubscriptionPlan::create([
            'name' => $this->name,
            'slug' => $slug,
            'stripe_plan_id' => $this->stripe_plan_id,
            'price' => $this->price,
            'billing_period' => $this->billing_period,
            'features' => $this->features ? explode(',', $this->features) : [],
            'is_active' => $this->is_active,
        ]);

        $this->showModal = false;
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Plano criado com sucesso!',
            'title' => 'Plano Criado',
        ]);
    }

    public function edit($id)
    {
        $this->resetValidation();
        $plan = SubscriptionPlan::findOrFail($id);
        $this->planId = $plan->id;
        $this->name = $plan->name;
        $this->price = $plan->price;
        $this->stripe_plan_id = $plan->stripe_plan_id;
        $this->billing_period = $plan->billing_period;
        $this->features = is_array($plan->features) ? implode(',', $plan->features) : $plan->features;
        $this->is_active = (bool) $plan->is_active;

        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'stripe_plan_id' => 'required|unique:subscription_plans,stripe_plan_id,'.$this->planId,
            'price' => 'required|integer',
            'billing_period' => 'required|in:monthly,yearly',
            'features' => 'nullable|string',
        ]);

        $plan = SubscriptionPlan::findOrFail($this->planId);

        $plan->update([
            'name' => $this->name,
            'stripe_plan_id' => $this->stripe_plan_id,
            'price' => $this->price,
            'billing_period' => $this->billing_period,
            'features' => $this->features ? explode(',', $this->features) : [],
            'is_active' => $this->is_active,
        ]);

        $this->showModal = false;
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Plano atualizado com sucesso!',
            'title' => 'Plano Atualizado',
        ]);
    }

    public function confirmDelete($id)
    {
        $this->planToDelete = SubscriptionPlan::findOrFail($id);
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        if ($this->planToDelete) {
            $this->planToDelete->delete();
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => 'Plano removido com sucesso!',
                'title' => 'Plano Excluído',
            ]);
        }
        $this->confirmingDeletion = false;
        $this->planToDelete = null;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
