<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterSubscription;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            Mail::to($request->email)->send(new NewsletterSubscription());
            Mail::to('admin@phpforge.com')->send(new NewsletterSubscription($request->email));

            return back()->with('success', 'Thank you for subscribing to our newsletter!');
        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, there was an error. Please try again later.');
        }
    }
}
