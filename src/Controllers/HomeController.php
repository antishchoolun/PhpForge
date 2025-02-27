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
        $this->render('home', [
            'title' => 'PhpForge - AI-Powered PHP Tools',
            'description' => 'Transform your PHP workflow with our suite of AI-powered tools.',
            'currentPage' => 'home'
        ]);
    }

    /**
     * Display the tools page
     */
    public function tools(): void
    {
        $tools = [
            [
                'id' => 'code-generator',
                'name' => 'PHP Code Generator',
                'description' => 'Transform natural language into clean, efficient PHP code.',
                'icon' => 'code',
                'tag' => 'AI-Powered'
            ],
            [
                'id' => 'debugging',
                'name' => 'AI Debugging & Error Checking',
                'description' => 'Identify and fix bugs instantly with intelligent error analysis.',
                'icon' => 'bug',
                'tag' => 'AI-Powered'
            ],
            [
                'id' => 'security',
                'name' => 'Security Analysis Tool',
                'description' => 'Scan your PHP code for vulnerabilities and get actionable recommendations.',
                'icon' => 'shield',
                'tag' => 'Security'
            ],
            [
                'id' => 'performance',
                'name' => 'Performance Optimization',
                'description' => 'Enhance your PHP code\'s performance with AI-generated suggestions.',
                'icon' => 'zap',
                'tag' => 'AI-Powered'
            ],
            [
                'id' => 'documentation',
                'name' => 'Documentation Generator',
                'description' => 'Create comprehensive documentation from your code automatically.',
                'icon' => 'file-text',
                'tag' => 'AI-Powered'
            ],
            [
                'id' => 'domain-valuation',
                'name' => 'Domain Valuation Tool',
                'description' => 'Get accurate valuations for domain names using AI market analysis.',
                'icon' => 'globe',
                'tag' => 'AI-Powered'
            ]
        ];

        $this->render('tools', [
            'title' => 'AI-Powered PHP Tools - PhpForge',
            'description' => 'Explore our suite of AI-powered PHP development tools.',
            'currentPage' => 'tools',
            'tools' => $tools
        ]);
    }

    /**
     * Display the pricing page
     */
    public function pricing(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'price' => 0,
                'description' => 'Perfect for trying out our tools',
                'features' => [
                    'Basic code generation',
                    'Simple debugging assistance',
                    'Limited API calls per day',
                    'Community support'
                ]
            ],
            [
                'name' => 'Pro',
                'price' => 29,
                'description' => 'Ideal for professional developers',
                'features' => [
                    'Advanced code generation',
                    'Comprehensive debugging',
                    'Security analysis',
                    'Performance optimization',
                    'Priority support',
                    'Unlimited API calls'
                ]
            ],
            [
                'name' => 'Enterprise',
                'price' => 99,
                'description' => 'For teams and organizations',
                'features' => [
                    'Everything in Pro',
                    'Team collaboration',
                    'Custom integrations',
                    'Advanced analytics',
                    'Dedicated support',
                    'SLA guarantees'
                ]
            ]
        ];

        $this->render('pricing', [
            'title' => 'Pricing - PhpForge',
            'description' => 'Choose the perfect plan for your PHP development needs.',
            'currentPage' => 'pricing',
            'plans' => $plans
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
        // In a real application, you would fetch blog posts from the database
        $posts = $this->service('db')->fetchAll(
            "SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 10"
        );

        $this->render('blog', [
            'title' => 'Blog - PhpForge',
            'description' => 'Latest news, tutorials and updates from PhpForge.',
            'currentPage' => 'blog',
            'posts' => $posts
        ]);
    }

    /**
     * Handle the contact form submission
     */
    public function contact(): void
    {
        if ($this->request['method'] === 'POST') {
            $data = $this->validate([
                'name' => 'required|max:100',
                'email' => 'required|email',
                'subject' => 'required|max:200',
                'message' => 'required|max:1000'
            ]);

            try {
                // Send email
                // In a real application, you would use a proper email service
                mail(
                    $_ENV['CONTACT_EMAIL'],
                    "Contact Form: {$data['subject']}",
                    $data['message'],
                    "From: {$data['email']}\r\nReply-To: {$data['email']}"
                );

                $this->success('Thank you for your message. We\'ll get back to you soon.');
            } catch (\Exception $e) {
                $this->error('Sorry, we couldn\'t send your message. Please try again later.');
            }
        }

        $this->render('contact', [
            'title' => 'Contact Us - PhpForge',
            'description' => 'Get in touch with the PhpForge team.',
            'currentPage' => 'contact'
        ]);
    }
}