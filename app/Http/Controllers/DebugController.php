<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Portfolio;

class DebugController extends Controller
{
    public function debug(Request $request)
    {
        // Log all input data for debugging
        Log::info('Debug Request Data', [
            'request_method' => $request->method(),
            'request_all' => $request->all(),
            'request_files' => $request->allFiles(),
            'request_content_type' => $request->header('Content-Type'),
        ]);

        return response()->json([
            'message' => 'Debug information logged',
            'data' => $request->all()
        ]);
    }

    public function diagnosticForm()
    {
        // Get first portfolio for testing
        $portfolio = Portfolio::first();
        
        if (!$portfolio) {
            return "No portfolio found in database.";
        }
        
        return view('debug.form', compact('portfolio'));
    }
}
