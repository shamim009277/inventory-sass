<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Http\Requests\SubscriptionPlanRequest;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SubscriptionPlan::query();
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('duration', 'like', "%{$search}%")
                    ->orWhere('interval', 'like', "%{$search}%");

                if (strtolower($search) === 'active') {
                    $q->orWhere('is_active', true);
                } elseif (strtolower($search) === 'inactive') {
                    $q->orWhere('is_active', false);
                }
            });
        }

        $perPage = $request->perPage ?? 10;

        return Inertia::render('SubscriptionPlans/Index', [
            'plans' => $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString(),
            'filters' => [
                'search' => $request->search,
                'perPage' => $perPage,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionPlanRequest $request)
    {
        try {
            SubscriptionPlan::create($request->validated());
            return redirect()->back()->with('success', 'Subscription Plan created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionPlanRequest $request, $id)
    {
        try {
            $plan = SubscriptionPlan::findOrFail($id);
            $plan->update($request->validated());
            return redirect()->back()->with('success', 'Subscription Plan updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, SubscriptionPlan $plan)
    {
        $plan->update([
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->back()->with('success', 'Status changed successfully.');
    }
}
