<?php
/**
 * Helper Functions
 * 
 * This file contains utility functions used throughout the application
 */

/**
 * Generate a secure random token
 * @param int $length Length of the token
 * @return string The generated token
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Validate email address
 * @param string $email Email to validate
 * @return bool True if valid, false otherwise
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Format a timestamp for display
 * @param string $timestamp The timestamp to format
 * @param string $format Optional format string
 * @return string Formatted date/time
 */
function formatDate($timestamp, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($timestamp));
}

/**
 * Format bytes to human readable size
 * @param int $bytes Number of bytes
 * @return string Formatted size
 */
function formatBytes($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, 2) . ' ' . $units[$pow];
}

/**
 * Check if string contains HTML
 * @param string $string String to check
 * @return bool True if contains HTML
 */
function containsHTML($string) {
    return $string !== strip_tags($string);
}

/**
 * Get user's IP address
 * @return string IP address
 */
function getUserIP() {
    return $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
}

/**
 * Generate a slug from a string
 * @param string $string String to convert
 * @return string URL-friendly slug
 */
function generateSlug($string) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
}

/**
 * Check if current request is AJAX
 * @return bool True if AJAX request
 */
function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Validate password strength
 * @param string $password Password to validate
 * @return array Array of validation results
 */
function validatePassword($password) {
    $results = [
        'length' => strlen($password) >= PASSWORD_MIN_LENGTH,
        'lowercase' => preg_match('/[a-z]/', $password),
        'uppercase' => preg_match('/[A-Z]/', $password),
        'number' => preg_match('/[0-9]/', $password),
        'special' => preg_match('/[^A-Za-z0-9]/', $password)
    ];
    $results['valid'] = !in_array(false, $results, true);
    return $results;
}

/**
 * Rate limit check
 * @param string $key Rate limit key
 * @param int $limit Number of allowed requests
 * @param int $interval Interval in seconds
 * @return bool True if within limit
 */
function checkRateLimit($key, $limit = 60, $interval = 60) {
    $current = time();
    $rateKey = "rate_limit:{$key}";
    
    if (!isset($_SESSION[$rateKey])) {
        $_SESSION[$rateKey] = [
            'count' => 1,
            'reset' => $current + $interval
        ];
        return true;
    }

    if ($_SESSION[$rateKey]['reset'] <= $current) {
        $_SESSION[$rateKey] = [
            'count' => 1,
            'reset' => $current + $interval
        ];
        return true;
    }

    if ($_SESSION[$rateKey]['count'] >= $limit) {
        return false;
    }

    $_SESSION[$rateKey]['count']++;
    return true;
}

/**
 * Format error message for display
 * @param string $message Error message
 * @param string $type Error type (error, warning, info)
 * @return string Formatted HTML
 */
function formatError($message, $type = 'error') {
    $types = [
        'error' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
        'success' => 'success'
    ];
    $class = $types[$type] ?? 'info';
    return "<div class='alert alert-{$class}'>{$message}</div>";
}

/**
 * Validate file upload
 * @param array $file $_FILES array element
 * @param array $allowedTypes Allowed mime types
 * @param int $maxSize Maximum file size in bytes
 * @return array Validation results
 */
function validateFileUpload($file, $allowedTypes = null, $maxSize = null) {
    if ($allowedTypes === null) {
        $allowedTypes = ALLOWED_FILE_TYPES;
    }
    if ($maxSize === null) {
        $maxSize = MAX_UPLOAD_SIZE;
    }

    $results = [
        'valid' => true,
        'errors' => []
    ];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $results['valid'] = false;
        $results['errors'][] = 'Upload failed with error code: ' . $file['error'];
        return $results;
    }

    if ($file['size'] > $maxSize) {
        $results['valid'] = false;
        $results['errors'][] = 'File size exceeds maximum allowed size of ' . formatBytes($maxSize);
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedTypes)) {
        $results['valid'] = false;
        $results['errors'][] = 'File type not allowed';
    }

    return $results;
}

/**
 * Get user's browser info
 * @return array Browser information
 */
function getBrowserInfo() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    return [
        'user_agent' => $userAgent,
        'browser' => get_browser($userAgent, true),
        'ip' => getUserIP(),
        'timestamp' => time()
    ];
}

/**
 * Clean input data
 * @param mixed $data Data to clean
 * @return mixed Cleaned data
 */
function cleanInput($data) {
    if (is_array($data)) {
        return array_map('cleanInput', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate pagination links
 * @param int $total Total number of items
 * @param int $page Current page number
 * @param int $perPage Items per page
 * @return array Pagination data
 */
function getPagination($total, $page = 1, $perPage = ITEMS_PER_PAGE) {
    $totalPages = ceil($total / $perPage);
    $page = max(1, min($page, $totalPages));
    
    return [
        'current_page' => $page,
        'total_pages' => $totalPages,
        'items_per_page' => $perPage,
        'total_items' => $total,
        'has_previous' => $page > 1,
        'has_next' => $page < $totalPages,
        'previous_page' => $page - 1,
        'next_page' => $page + 1,
        'offset' => ($page - 1) * $perPage
    ];
}