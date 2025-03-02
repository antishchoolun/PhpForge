<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CareersController extends Controller
{
    public function index()
    {
        // Simulated job listings - in a real app, these would come from a database
        $openings = [
            [
                'title' => 'Senior PHP Developer',
                'department' => 'Engineering',
                'location' => 'Australia (Remote Optional)',
                'type' => 'Full-time',
                'description' => 'We\'re looking for an experienced PHP developer to help build and maintain our core products.'
            ],
            [
                'title' => 'Frontend Developer',
                'department' => 'Engineering',
                'location' => 'Australia (Remote Optional)',
                'type' => 'Full-time',
                'description' => 'Join our team to create beautiful, responsive user interfaces using modern web technologies.'
            ],
            [
                'title' => 'Technical Support Engineer',
                'department' => 'Customer Success',
                'location' => 'Australia',
                'type' => 'Full-time',
                'description' => 'Help our customers succeed by providing expert technical support and guidance.'
            ],
            [
                'title' => 'Product Manager',
                'department' => 'Product',
                'location' => 'Australia',
                'type' => 'Full-time',
                'description' => 'Drive the vision and strategy for our product suite, working closely with engineering and design.'
            ]
        ];

        return view('pages.careers', compact('openings'));
    }

    public function apply(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'position' => 'required|string|max:255',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        // Here you would typically:
        // 1. Store the resume file
        // 2. Save application to database
        // 3. Send notification emails
        // 4. etc.

        return redirect()->route('careers')
            ->with('success', 'Thank you for your application! We\'ll review it and get back to you soon.');
    }
}
