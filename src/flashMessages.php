<?php

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
