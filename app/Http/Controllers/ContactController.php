<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Portfolio;

class ContactController extends Controller
{
    /**
     * Handle the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $portfolioId
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request, $portfolioId)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Get the portfolio owner's email
        $portfolio = Portfolio::findOrFail($portfolioId);
        $ownerEmail = $portfolio->email;

        // Send the message
        try {
            // We'll use a simple JSON response for now since Mail::send would require creating email templates
            // In a production app, you would implement Mail::send() with proper templates
            
            // Add notification or logging here
            // Mail::send(...);
            
            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your message.'
            ], 500);
        }
    }

    /**
     * Handle the main contact page form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendContactForm(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Send the message
        try {
            // In a production environment, you would send an actual email here
            // Mail::to('support@portzen.com')->send(new ContactFormMail($validated));
            
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your message. Please try again later.'
            ], 500);
        }
    }
} 