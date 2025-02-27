<?php
/**
 * User Dashboard
 * Shows user's account information, tools, and recent activity
 */

require_once __DIR__ . '/../src/config/init.php';

// Ensure user is logged in
if (!isLoggedIn()) {
    redirect('/PhpForge/public/auth/signin.php');
}

// Get user data
try {
    $stmt = $db->prepare("
        SELECT u.*, 
               COUNT(DISTINCT tu.id) as total_tools_used,
               COUNT(DISTINCT cs.id) as total_snippets
        FROM users u
        LEFT JOIN tool_usage tu ON u.id = tu.user_id
        LEFT JOIN code_snippets cs ON u.id = cs.user_id
        WHERE u.id = ?
        GROUP BY u.id
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        // User not found in database
        session_destroy();
        redirect('/PhpForge/public/auth/signin.php');
    }

    // Get recent activity
    $stmt = $db->prepare("
        SELECT tool_name, created_at, status
        FROM tool_usage
        WHERE user_id = ?
        ORDER BY created_at DESC
        LIMIT 5
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $recentActivity = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log("Dashboard Error: " . $e->getMessage());
    die("Error loading dashboard data. Please try again later.");
}

// Get plan limits
$planLimits = PLAN_LIMITS[$user['plan_type']];

// Calculate usage percentages
$usagePercentage = ($user['requests_today'] / $planLimits['requests_per_day']) * 100;

// Set page title
$pageTitle = "Dashboard";

// Include header
require_once __DIR__ . '/../src/components/layout/header.php';
?>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <section class="dashboard-welcome">
        <div class="welcome-content">
            <h1>Welcome back, <?= e($user['first_name']) ?>!</h1>
            <p class="plan-badge <?= $user['plan_type'] ?>">
                <?= ucfirst($user['plan_type']) ?> Plan
            </p>
        </div>
        <div class="usage-stats">
            <div class="usage-meter">
                <div class="usage-fill" style="width: <?= min($usagePercentage, 100) ?>%"></div>
            </div>
            <p>
                <?= $user['requests_today'] ?>/<?= $planLimits['requests_per_day'] ?> 
                requests used today
            </p>
        </div>
    </section>

    <div class="dashboard-grid">
        <!-- Tools Section -->
        <section class="dashboard-section tools-section">
            <h2>Available Tools</h2>
            <div class="tools-grid">
                <?php foreach ($planLimits['tools_available'] as $tool): ?>
                    <a href="/PhpForge/public/tools/<?= $tool ?>.php" class="tool-card">
                        <div class="tool-icon">
                            <?php include __DIR__ . "/../src/components/icons/{$tool}.php"; ?>
                        </div>
                        <h3><?= ucwords(str_replace('_', ' ', $tool)) ?></h3>
                        <p><?= getToolDescription($tool) ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Recent Activity -->
        <section class="dashboard-section activity-section">
            <h2>Recent Activity</h2>
            <?php if (empty($recentActivity)): ?>
                <p class="no-activity">No recent activity to show</p>
            <?php else: ?>
                <div class="activity-list">
                    <?php foreach ($recentActivity as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-icon <?= $activity['status'] ?>">
                                <?php include __DIR__ . "/../src/components/icons/{$activity['tool_name']}.php"; ?>
                            </div>
                            <div class="activity-details">
                                <h4><?= ucwords(str_replace('_', ' ', $activity['tool_name'])) ?></h4>
                                <p><?= formatDate($activity['created_at'], 'M j, Y g:i A') ?></p>
                            </div>
                            <span class="activity-status <?= $activity['status'] ?>">
                                <?= ucfirst($activity['status']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- Account Overview -->
        <section class="dashboard-section account-section">
            <h2>Account Overview</h2>
            <div class="account-stats">
                <div class="stat-card">
                    <h4>Tools Used</h4>
                    <p><?= $user['total_tools_used'] ?></p>
                </div>
                <div class="stat-card">
                    <h4>Code Snippets</h4>
                    <p><?= $user['total_snippets'] ?></p>
                </div>
                <div class="stat-card">
                    <h4>Member Since</h4>
                    <p><?= formatDate($user['created_at'], 'M Y') ?></p>
                </div>
            </div>
            <div class="account-actions">
                <a href="/PhpForge/public/account/profile.php" class="btn btn-outline">
                    Edit Profile
                </a>
                <a href="/PhpForge/public/account/plan.php" class="btn btn-primary">
                    Upgrade Plan
                </a>
            </div>
        </section>
    </div>
</div>

<?php
/**
 * Get tool description
 * @param string $tool Tool identifier
 * @return string Tool description
 */
function getToolDescription($tool) {
    $descriptions = [
        'code_generator' => 'Generate PHP code from natural language',
        'debug_basic' => 'Basic debugging and error checking',
        'debug_advanced' => 'Advanced debugging with AI assistance',
        'security' => 'Security vulnerability scanning',
        'performance' => 'Code performance optimization',
        'documentation' => 'Generate comprehensive documentation',
        'domain' => 'AI-powered domain valuation'
    ];
    return $descriptions[$tool] ?? '';
}

// Include footer
require_once __DIR__ . '/../src/components/layout/footer.php';
?>