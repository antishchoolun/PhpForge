<div id="code-generator-modal" class="modal">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-content custom-scrollbar">
        <div class="modal-header">
            <h2>PHP Code Generator</h2>
            <button class="close-modal" onclick="closeModal('code-generator')">&times;</button>
        </div>
        <div class="tool-interface">
            <form id="code-generator-form" class="space-y-4">
                <div class="input-group">
                    <label for="code-prompt">Describe what you need in plain language:</label>
                    <textarea id="code-prompt" name="prompt" class="input-control" required
                        placeholder="Example: Create a PHP function that connects to a MySQL database and fetches all users from a 'users' table"></textarea>
                </div>
                <div class="input-group">
                    <label for="framework">Framework/Platform:</label>
                    <select id="framework" name="framework" class="input-control" required>
                        <option value="raw">Raw PHP</option>
                        <option value="laravel">Laravel</option>
                        <option value="symfony">Symfony</option>
                        <option value="wordpress">WordPress</option>
                        <option value="codeigniter">CodeIgniter</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Component Type:</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="component" value="controller" checked>
                            <span class="radio-text">Controller</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="component" value="model">
                            <span class="radio-text">Model</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="component" value="service">
                            <span class="radio-text">Service</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="component" value="repository">
                            <span class="radio-text">Repository</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="component" value="middleware">
                            <span class="radio-text">Middleware</span>
                        </label>
                    </div>
                </div>

                <div class="input-group patterns-group">
                    <label>Design Patterns to Include:</label>
                    <div class="checkbox-grid">
                        <label class="checkbox-label">
                            <input type="checkbox" name="patterns[]" value="crud">
                            <span class="checkbox-text">CRUD Operations</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="patterns[]" value="repository">
                            <span class="checkbox-text">Repository Pattern</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="patterns[]" value="service">
                            <span class="checkbox-text">Service Layer</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="patterns[]" value="factory">
                            <span class="checkbox-text">Factory Pattern</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="patterns[]" value="dependency">
                            <span class="checkbox-text">Dependency Injection</span>
                        </label>
                    </div>
                </div>

                <div class="input-group version-group">
                    <label>PHP Version Features:</label>
                    <div class="version-selector">
                        <label class="version-option">
                            <input type="radio" name="php_version" value="7.4">
                            <span class="version-box">
                                <span class="version-number">7.4</span>
                                <span class="version-feature">Typed Properties</span>
                            </span>
                        </label>
                        <label class="version-option">
                            <input type="radio" name="php_version" value="8.0">
                            <span class="version-box">
                                <span class="version-number">8.0</span>
                                <span class="version-feature">Constructor Props</span>
                            </span>
                        </label>
                        <label class="version-option">
                            <input type="radio" name="php_version" value="8.1" checked>
                            <span class="version-box">
                                <span class="version-number">8.1</span>
                                <span class="version-feature">Enums & More</span>
                            </span>
                        </label>
                        <label class="version-option">
                            <input type="radio" name="php_version" value="8.2">
                            <span class="version-box">
                                <span class="version-number">8.2</span>
                                <span class="version-feature">Readonly Classes</span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="input-group">
                    <label>Additional Options:</label>
                    <div class="flex gap-4 flex-wrap">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="options[]" value="comments" checked> Include comments
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="options[]" value="error_handling" checked> Error handling
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="options[]" value="psr12"> PSR-12 compliance
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="options[]" value="type_hints"> Type hinting
                        </label>
                    </div>
                </div>
                <button type="submit" id="generate-code-btn" class="btn btn-primary">
                    Generate Code
                </button>
            </form>

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