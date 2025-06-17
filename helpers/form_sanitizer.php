<?php

function sanitizeInput( string $data): string {
    // Trim whitespace from the beginning and end of the string
    $data = trim($data);
    // Remove backslashes
    $data = stripslashes($data);
    // Convert special characters to HTML entities to prevent XSS attacks
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}