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
            if ($type === 'error') {
            // You can add styling for different message types (e.g., 'error', 'success')
            echo '<div class="flash-message ' . htmlspecialchars($type) . '"
                    style="padding:10px; 
                    background:#f8d7da; 
                    color:#721c24;
                    border:1px solid #f5c6cb; 
                    border-radius:5px; 
                    margin-bottom:10px;">
                    ' . htmlspecialchars($message) . '
            </div>';
            }
            elseif ($type === 'success') {
                echo '<div class="flash-message ' . htmlspecialchars($type) . '"
                        style="padding:10px; 
                        background:#d4edda; 
                        color:#155724;
                        border:1px solid #c3e6cb; 
                        border-radius:5px; 
                        margin-bottom:10px;">
                        ' . htmlspecialchars($message) . '
                </div>';
            }
        }
        // Unset the flash message so it doesn't show on subsequent page loads.
        unset($_SESSION['flash']);
    }
}
