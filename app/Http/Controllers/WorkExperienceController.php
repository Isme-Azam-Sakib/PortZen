<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkExperienceController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(WorkExperience $experience)
    {
        // Check if user owns the portfolio
        if ($experience->portfolio->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this experience.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'experience' => $experience
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id',
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'responsibilities' => 'nullable|string'
        ]);

        // Check if user owns the portfolio
        $portfolio = Portfolio::findOrFail($validated['portfolio_id']);
        if ($portfolio->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to add experiences to this portfolio.'
            ], 403);
        }

        try {
            $experience = WorkExperience::create([
                'portfolio_id' => $validated['portfolio_id'],
                'job_title' => $validated['job_title'],
                'company_name' => $validated['company_name'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['is_current'] ? null : $validated['end_date'],
                'is_current' => $validated['is_current'] ?? false,
                'responsibilities' => $validated['responsibilities'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Experience created successfully',
                'experience' => $experience
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create work experience', [
                'error' => $e->getMessage(),
                'portfolio_id' => $validated['portfolio_id']
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create experience: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkExperience $experience)
    {
        // Check if user owns the portfolio
        if ($experience->portfolio->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this experience.'
            ], 403);
        }

        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'responsibilities' => 'nullable|string'
        ]);

        try {
            $experience->update([
                'job_title' => $validated['job_title'],
                'company_name' => $validated['company_name'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['is_current'] ? null : $validated['end_date'],
                'is_current' => $validated['is_current'] ?? false,
                'responsibilities' => $validated['responsibilities'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Experience updated successfully',
                'experience' => $experience
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update work experience', [
                'error' => $e->getMessage(),
                'experience_id' => $experience->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update experience: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkExperience $experience)
    {
        // Check if user owns the portfolio
        if ($experience->portfolio->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this experience.'
            ], 403);
        }

        try {
            $experience->delete();

            return response()->json([
                'success' => true,
                'message' => 'Experience deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete work experience', [
                'error' => $e->getMessage(),
                'experience_id' => $experience->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete experience: ' . $e->getMessage()
            ], 500);
        }
    }
} 