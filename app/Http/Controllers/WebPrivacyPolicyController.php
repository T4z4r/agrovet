<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WebPrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $privacyPolicies = PrivacyPolicy::all();
        return view('privacy-policies.index', compact('privacyPolicies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('privacy-policies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        PrivacyPolicy::create($request->all());

        return redirect()->route('web.privacy-policies.index')->with('success', 'Privacy policy created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PrivacyPolicy $privacyPolicy): View
    {
        return view('privacy-policies.show', compact('privacyPolicy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrivacyPolicy $privacyPolicy): View
    {
        return view('privacy-policies.edit', compact('privacyPolicy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrivacyPolicy $privacyPolicy): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $privacyPolicy->update($request->all());

        return redirect()->route('web.privacy-policies.index')->with('success', 'Privacy policy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrivacyPolicy $privacyPolicy): RedirectResponse
    {
        $privacyPolicy->delete();

        return redirect()->route('web.privacy-policies.index')->with('success', 'Privacy policy deleted successfully');
    }
}
