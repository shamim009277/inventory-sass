<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Requests\ModuleRequest;


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Module::query();
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $perPage = $request->perPage ?? 5;

        return Inertia::render('Module/Index', [
            'modules' => $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString(),
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
    public function store(ModuleRequest $request)
    {
        try {
            $module = Module::create($request->validated());
            return redirect()->route('modules.index')->with('success', 'Module created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create module: ' . $e->getMessage());
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(module $module)
    {
        $module->delete();

        return redirect()->back()->with('success', 'Module deleted successfully.');
    }
}
