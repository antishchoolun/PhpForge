<?php

namespace PhpForge\Controllers;

use PhpForge\Core\Controller;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index(): void
    {
        $this->debug('HomeController: Handling index request');

        // Get latest blog posts for homepage
        try {
            $posts = $this->db->fetchAll(
                "SELECT title, excerpt, slug 
                FROM blog_posts 
                WHERE status = 'published' 
                ORDER BY published_at DESC 
                LIMIT 3"
            );
        } catch (\Exception $e) {
            $this->debug('Error fetching blog posts', ['error' => $e->getMessage()]);
            $posts = []; // Empty array if table doesn't exist or query fails
        }

        $this->debug('Rendering home page', ['postsCount' => count($posts)]);

        $this->render('home', [
            'title' => 'PhpForge - AI-Powered PHP Tools',
            'description' => 'Transform your PHP workflow with our suite of AI-powered tools.',
            'currentPage' => 'home',
            'posts' => $posts
        ]);
    }

    /**
     * Display the tools page
     */
    public function tools(): void
    {
        $this->render('tools', [
            'title' => 'Our Tools - PhpForge',
            'description' => 'Explore our suite of AI-powered PHP development tools.',
            'currentPage' => 'tools'
        ]);
    }

    /**
     * Display the pricing page
     */
    public function pricing(): void
    {
        $this->render('pricing', [
            'title' => 'Pricing - PhpForge',
            'description' => 'Choose the perfect plan for your PHP development needs.',
            'currentPage' => 'pricing'
        ]);
    }

    /**
     * Display the documentation page
     */
    public function documentation(): void
    {
        $this->render('documentation', [
            'title' => 'Documentation - PhpForge',
            'description' => 'Learn how to use PhpForge\'s AI-powered PHP tools.',
            'currentPage' => 'docs'
        ]);
    }

    /**
     * Display the blog page
     */
    public function blog(): void
    {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        try {
            // Get blog posts with pagination
            $posts = $this->db->fetchAll(
                "SELECT * 
                FROM blog_posts 
                WHERE status = 'published' 
                ORDER BY published_at DESC 
                LIMIT ? OFFSET ?",
                [$perPage, $offset]
            );

            // Get total count for pagination
            $total = $this->db->fetch(
                "SELECT COUNT(*) as count 
                FROM blog_posts 
                WHERE status = 'published'"
            );
        } catch (\Exception $e) {
            $this->debug('Error fetching blog posts', ['error' => $e->getMessage()]);
            $posts = [];
            $total = ['count' => 0];
        }

        $this->render('blog', [
            'title' => 'Blog - PhpForge',
            'description' => 'Latest news, tutorials and updates from PhpForge.',
            'currentPage' => 'blog',
            'posts' => $posts,
            'pagination' => [
                'current' => $page,
                'perPage' => $perPage,
                'total' => (int) ($total['count'] ?? 0)
            ]
        ]);
    }
}