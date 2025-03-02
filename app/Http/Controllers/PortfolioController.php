<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function create()
    {
        $templates = Template::where('is_active', true)->get();
        return view('portfolios.create', compact('templates'));
    }

    public function setup(Request $request)
    {
        $template = Template::findOrFail($request->template_id);
        return view('portfolios.setup', compact('template'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'template_id' => 'required|exists:templates,id',
            'full_name' => 'required|max:255',
            'tagline' => 'nullable|max:255',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'skills' => 'nullable|array',
            'tools' => 'nullable|array',
            'experience_level' => 'required|in:beginner,intermediate,expert',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'website_url' => 'nullable|url',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required|string|in:behance,dribbble,linkedin,instagram,twitter',
            'social_links.*.url' => 'required|url'
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')
                ->store('profile-images', 'public');
        }

        // Create portfolio with slug
        $portfolio = auth()->user()->portfolios()->create([
            ...$validated,
            'slug' => Str::slug($validated['title']) . '-' . Str::random(6)
        ]);

        return redirect()->route('portfolios.edit', $portfolio)
            ->with('success', 'Portfolio created successfully!');
    }

    public function show(Portfolio $portfolio)
    {
        return view('portfolios.show', compact('portfolio'));
    }
}

