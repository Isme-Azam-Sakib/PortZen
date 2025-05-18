<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display the templates page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $templates = Template::where('is_active', true)->get();
        
        return view('templates', [
            'templates' => $templates
        ]);
    }
} 