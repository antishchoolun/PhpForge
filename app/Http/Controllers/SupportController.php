<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function index()
    {
        return view('pages.support');
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Here you would typically send an email
        // For now, we'll just redirect with success message
        return redirect()->route('support')
            ->with('success', 'Thank you for reaching out! We\'ll get back to you soon.');
    }
}
