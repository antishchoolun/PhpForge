# PhpForge Authentication Implementation

## Overview
This document tracks the implementation of authentication and usage limits in PhpForge.

## Features
- Guest users get 5 free requests per day
- Usage resets daily at midnight UTC
- Free registration removes usage limits
- No payment or subscription required

## Database Schema

### Guest Usage Tracking
```sql
CREATE TABLE guest_usage (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    session_id VARCHAR(255) NOT NULL,
    usage_count INT UNSIGNED DEFAULT 0,
    last_reset TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_ip_session (ip_address, session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Implementation Status

### Database
- [x] Create guest_usage migration
- [x] Add last_used_at to users table migration
- [x] Create database seeders for testing

### Authentication
- [x] Set up Laravel Breeze
- [x] Create login page
- [x] Create registration page
- [x] Implement auth routes
- [x] Style auth pages with Tailwind

### Usage Tracking
- [x] Create TrackUsage middleware
- [x] Implement usage counting logic
- [x] Add usage display component

### Frontend
- [x] Update header with auth buttons
- [x] Create usage counter component
- [x] Update pricing page
- [x] Add registration prompts

### Testing
- [x] Guest usage limit tests
- [x] Auth flow tests
- [x] Usage reset tests
- [x] Integration tests

### Test Coverage
- Guest user can use tools within daily limits
- Guest user cannot exceed daily limit
- Usage counter resets after day
- Registered users have unlimited access
- Session handling and IP tracking
- Database cleanup and test isolation
