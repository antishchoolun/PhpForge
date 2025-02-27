<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhpForge.com - AI-Powered PHP Tools</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --dark: #1e293b;
            --light: #f8fafc;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray: #64748b;
            --card-bg: rgba(255, 255, 255, 0.8);
        }

        @font-face {
            font-family: 'Satoshi';
            src: url('https://cdnjs.cloudflare.com/ajax/libs/font-family/Satoshi-Variable.woff2') format('woff2');
            font-weight: 300 900;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Satoshi', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
            color: var(--dark);
            min-height: 100vh;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            padding: 1.5rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo span {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        nav ul {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            position: relative;
            transition: color 0.3s;
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            transition: width 0.3s;
        }

        nav a:hover::after {
            width: 100%;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-outline:hover {
            background: rgba(99, 102, 241, 0.05);
            transform: translateY(-2px);
        }

        .hero {
            padding: 5rem 0 3rem;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(to right, var(--dark), var(--primary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        .tool-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin: 3rem 0;
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.4);
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .card-accent {
            height: 6px;
            width: 100%;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        .card-content {
            padding: 1.5rem;
        }

        .card-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            margin-bottom: 1rem;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            font-size: 1.5rem;
        }

        .card h3 {
            font-size: 1.4rem;
            margin-bottom: 0.8rem;
        }

        .card p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .feature-tag {
            display: inline-block;
            font-size: 0.7rem;
            text-transform: uppercase;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .ai-tag {
            background: rgba(236, 72, 153, 0.1);
            color: var(--secondary);
        }

        .security-tag {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .floating {
            animation: float 4s ease-in-out infinite;
        }

        /* Custom glassmorphism modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .modal.active {
            opacity: 1;
            pointer-events: all;
        }

        .modal-content {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            width: 90%;
            max-width: 900px;
            padding: 2rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            transform: scale(0.9);
            transition: transform 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-header h2 {
            font-size: 1.8rem;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray);
            transition: color 0.2s;
        }

        .close-modal:hover {
            color: var(--danger);
        }

        .code-area {
            background: var(--dark);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1rem 0;
            overflow-x: auto;
            position: relative;
        }

        .code-area pre {
            color: #f8f8f2;
            font-family: 'Fira Code', monospace;
        }

        .code-area-tools {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            display: flex;
            gap: 0.5rem;
        }

        .code-area-tools button {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 4px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.2s;
        }

        .code-area-tools button:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Tool interface styles */
        .tool-interface {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .input-group label {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .input-control {
            padding: 0.8rem 1rem;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            transition: all 0.2s;
        }

        .input-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        textarea.input-control {
            min-height: 150px;
            resize: vertical;
        }

        /* Tabs for tool interface */
        .tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding-bottom: 0.5rem;
        }

        .tab {
            padding: 0.6rem 1rem;
            cursor: pointer;
            border-radius: 6px 6px 0 0;
            font-weight: 500;
            transition: all 0.2s;
        }

        .tab.active {
            background: var(--primary);
            color: white;
        }

        .tab:not(.active):hover {
            background: rgba(99, 102, 241, 0.1);
        }

        /* Spinner animation */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
            display: inline-block;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Console output area */
        .console {
            background: #282a36;
            color: #f8f8f2;
            padding: 1rem;
            border-radius: 8px;
            font-family: 'Fira Code', monospace;
            position: relative;
            margin-top: 1rem;
        }

        .console-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .console-content {
            max-height: 200px;
            overflow-y: auto;
        }

        .console-line {
            display: flex;
            margin-bottom: 0.3rem;
        }

        .console-prefix {
            color: var(--success);
            margin-right: 0.5rem;
        }

        /* Footer */
        footer {
            margin-top: 5rem;
            padding: 2rem 0;
            text-align: center;
            color: var(--gray);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                <span>PhpForge</span>.com
            </div>
            <nav>
                <ul>
                    <li><a href="#">Tools</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <button class="btn btn-outline">Sign In</button>
                <button class="btn btn-primary">Get Started</button>
            </div>
        </header>

        <section class="hero">
            <h1 class="animate__animated animate__fadeIn">PHP Development, <br>Supercharged by AI</h1>
            <p class="animate__animated animate__fadeIn animate__delay-1s">Transform your PHP workflow with our suite of AI-powered tools designed to help you code faster, debug smarter, and build more secure applications.</p>
            <button class="btn btn-primary animate__animated animate__fadeIn animate__delay-2s">Explore Tools</button>
        </section>

        <div class="tool-cards animate__animated animate__fadeInUp animate__delay-3s">
            <!-- PHP Code Generator -->
            <div class="card floating" style="animation-delay: 0.1s;" onclick="openModal('code-generator')">
                <div class="card-accent"></div>
                <div class="card-content">
                    <span class="feature-tag ai-tag">AI-Powered</span>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="16 18 22 12 16 6"></polyline>
                            <polyline points="8 6 2 12 8 18"></polyline>
                        </svg>
                    </div>
                    <h3>PHP Code Generator</h3>
                    <p>Transform natural language into clean, efficient PHP code with a single prompt.</p>
                    <button class="btn btn-primary">Generate Code</button>
                </div>
            </div>

            <!-- AI-Powered Debugging -->
            <div class="card floating" style="animation-delay: 0.2s;" onclick="openModal('debugging')">
                <div class="card-accent"></div>
                <div class="card-content">
                    <span class="feature-tag ai-tag">AI-Powered</span>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                            <path d="M12 13V7"></path>
                            <path d="M12 17.01 12.01 17"></path>
                        </svg>
                    </div>
                    <h3>AI Debugging & Error Checking</h3>
                    <p>Identify and fix bugs instantly with intelligent error analysis and solutions.</p>
                    <button class="btn btn-primary">Debug Code</button>
                </div>
            </div>

            <!-- Security Analysis Tool -->
            <div class="card floating" style="animation-delay: 0.3s;" onclick="openModal('security')">
                <div class="card-accent"></div>
                <div class="card-content">
                    <span class="feature-tag security-tag">Security</span>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <h3>Security Analysis Tool</h3>
                    <p>Scan your PHP code for vulnerabilities and get actionable security recommendations.</p>
                    <button class="btn btn-primary">Scan Code</button>
                </div>
            </div>

            <!-- Performance Optimization Tool -->
            <div class="card floating" style="animation-delay: 0.4s;" onclick="openModal('performance')">
                <div class="card-accent"></div>
                <div class="card-content">
                    <span class="feature-tag ai-tag">AI-Powered</span>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                        </svg>
                    </div>
                    <h3>Performance Optimization</h3>
                    <p>Enhance your PHP code's performance with AI-generated optimization suggestions.</p>
                    <button class="btn btn-primary">Optimize Code</button>
                </div>
            </div>

            <!-- Documentation Generator -->
            <div class="card floating" style="animation-delay: 0.5s;" onclick="openModal('documentation')">
                <div class="card-accent"></div>
                <div class="card-content">
                    <span class="feature-tag ai-tag">AI-Powered</span>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <path d="M14 2v6h6"></path>
                            <path d="M16 13H8"></path>
                            <path d="M16 17H8"></path>
                            <path d="M10 9H8"></path>
                        </svg>
                    </div>
                    <h3>Documentation Generator</h3>
                    <p>Create comprehensive, well-structured documentation directly from your code.</p>
                    <button class="btn btn-primary">Generate Docs</button>
                </div>
            </div>

            <!-- Domain Valuation Tool -->
            <div class="card floating" style="animation-delay: 0.6s;" onclick="openModal('domain-valuation')">
                <div class="card-accent"></div>
                <div class="card-content">
                    <span class="feature-tag ai-tag">AI-Powered</span>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a10 10 0 1 0 0 20 10 10 0 1 0 0-20z"></path>
                            <path d="M12 8v8"></path>
                            <path d="M8 12h8"></path>
                        </svg>
                    </div>
                    <h3>Domain Valuation Tool</h3>
                    <p>Get accurate valuations for domain names based on AI-powered market analysis.</p>
                    <button class="btn btn-primary">Evaluate Domain</button>
                </div>
            </div>
        </div>

        <!-- Tool Modals -->
        <!-- Code Generator Modal -->
        <div id="code-generator-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>PHP Code Generator</h2>
                    <button class="close-modal" onclick="closeModal('code-generator')">&times;</button>
                </div>
                <div class="tool-interface">
                    <div class="input-group">
                        <label for="code-prompt">Describe what you need in plain language:</label>
                        <textarea id="code-prompt" class="input-control" placeholder="Example: Create a PHP function that connects to a MySQL database and fetches all users from a 'users' table"></textarea>
                    </div>
                    <div class="input-group">
                        <label>Additional Options:</label>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <label style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox" checked> Include comments
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox" checked> Error handling
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox"> PSR-12 compliance
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox"> Type hinting
                            </label>
                        </div>
                    </div>
                    <button id="generate-code-btn" class="btn btn-primary" onclick="simulateCodeGeneration()">
                        Generate Code
                    </button>

                    <div id="code-result" style="display: none;">
                        <div class="code-area">
                            <div class="code-area-tools">
                                <button title="Copy code">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                </button>
                                <button title="Download">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </button>
                            </div>
                            <pre><code id="generated-code">/**
 * Connects to MySQL database and fetches all users
 * 
 * @return array|false Array of users or false on failure
 */
function fetchAllUsers() {
    try {
        // Database configuration
        $host = 'localhost';
        $dbname = 'your_database';
        $username = 'your_username';
        $password = 'your_password';
        
        // Create connection using PDO
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, $username, $password, $options);
        
        // Prepare and execute query
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        
        // Fetch all users as associative array
        return $stmt->fetchAll();
        
    } catch (PDOException $e) {
        // Log the error
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}</code></pre>
                        </div>
                        <div class="console">
                            <div class="console-header">
                                <div>AI Analysis</div>
                            </div>
                            <div class="console-content">
                                <div class="console-line">
                                    <span class="console-prefix">✓</span>
                                    <span>Using PDO for database connections (secure practice)</span>
                                </div>
                                <div class="console-line">
                                    <span class="console-prefix">✓</span>
                                    <span>Error handling implemented with try/catch</span>
                                </div>
                                <div class="console-line">
                                    <span class="console-prefix">✓</span>
                                    <span>Prepared statements prevent SQL injection</span>
                                </div>
                                <div class="console-line">
                                    <span class="console-prefix">ℹ</span>
                                    <span>Consider adding pagination for large datasets</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <p>© 2025 PhpForge.com • All Rights Reserved</p>
        </footer>
    </div>

    <script>
        // Modal functionality
        function openModal(modalName) {
            document.getElementById(`${modalName}-modal`).classList.add('active');
        }
        
        function closeModal(modalName) {
            document.getElementById(`${modalName}-modal`).classList.remove('active');
        }
        
        // Simulate code generation
        function simulateCodeGeneration() {
            const generateBtn = document.getElementById('generate-code-btn');
            const codeResult = document.getElementById('code-result');
            
            // Show loading state
            generateBtn.innerHTML = '<span class="spinner"></span> Generating...';
            generateBtn.disabled = true;
            
            // Simulate loading delay
            setTimeout(() => {
                // Hide loading and show result
                generateBtn.innerHTML = 'Generate Code';
                generateBtn.disabled = false;
                codeResult.style.display = 'block';
                
                // Scroll to result
                codeResult.scrollIntoView({ behavior: 'smooth' });
            }, 1500);
        }
        
        // Close modals when clicking outside
        window.addEventListener('click', (e) => {
            document.querySelectorAll('.modal').forEach(modal => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>