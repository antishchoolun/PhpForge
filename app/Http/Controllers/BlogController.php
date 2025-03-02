<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Simulated blog posts - in a real app, these would come from a database
        $posts = [
            [
                'title' => 'Introducing PhpForge AI Code Generator',
                'slug' => 'introducing-phpforge-ai-code-generator',
                'excerpt' => 'Learn how our new AI-powered code generator can help you write better PHP code faster.',
                'category' => 'Product Updates',
                'author' => 'Sarah Chen',
                'date' => '2025-03-01',
                'read_time' => '5 min read',
                'image' => 'https://placehold.co/800x400'
            ],
            [
                'title' => '10 PHP Performance Optimization Tips',
                'slug' => '10-php-performance-optimization-tips',
                'excerpt' => 'Discover practical tips and techniques to improve your PHP application\'s performance.',
                'category' => 'Tutorials',
                'author' => 'John Smith',
                'date' => '2025-02-28',
                'read_time' => '8 min read',
                'image' => 'https://placehold.co/800x400'
            ],
            [
                'title' => 'Best Practices for PHP Security in 2025',
                'slug' => 'best-practices-for-php-security-2025',
                'excerpt' => 'Stay up-to-date with the latest security practices and protect your PHP applications.',
                'category' => 'Security',
                'author' => 'Maria Garcia',
                'date' => '2025-02-25',
                'read_time' => '6 min read',
                'image' => 'https://placehold.co/800x400'
            ],
            [
                'title' => 'Understanding Modern PHP Features',
                'slug' => 'understanding-modern-php-features',
                'excerpt' => 'Deep dive into the latest PHP features and how they can improve your code.',
                'category' => 'Development',
                'author' => 'Alex Johnson',
                'date' => '2025-02-20',
                'read_time' => '7 min read',
                'image' => 'https://placehold.co/800x400'
            ]
        ];

        $categories = [
            'Product Updates' => 5,
            'Tutorials' => 12,
            'Security' => 8,
            'Development' => 15,
            'Community' => 6,
            'Case Studies' => 4
        ];

        return view('pages.blog', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        // In a real app, you would fetch the post from database
        // For now, just redirect to blog index
        return redirect()->route('blog');
    }
}
