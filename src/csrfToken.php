<?php

/**
 * Generates and returns a CSRF token, storing it in the session.
 * If a token already exists in the session, it will be returned.
 *
 * @return string The CSRF token.
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Returns an HTML hidden input tag with the CSRF token.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

/**
 * Displays and then clears flash messages from the session.
 */
function display_flash_messages(): void
{
    if (isset($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $type => $message) {
            // You can add styling for different message types (e.g., 'error', 'success')
            echo '<div class="flash-message ' . htmlspecialchars($type) . '">' . htmlspecialchars($message) . '</div>';
        }
        // Unset the flash message so it doesn't show on subsequent page loads.
        unset($_SESSION['flash']);
    }
}