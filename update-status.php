<?php
header('Content-Type: application/json');

// IMPORTANT: Implement proper authentication and authorization!
// The current 'nyrex2024' password in JS is client-side and insecure.
// For a real application, consider:
// - Session-based authentication
// - API keys
// - OAuth
// - IP whitelisting
// - A proper admin login system
function authenticate() {
    // This is a very basic placeholder for demonstration.
    // In a real scenario, you'd send the password (or an API key) in the request body
    // or as a header, and validate it securely on the server.
    $headers = getallheaders();
    $auth_header = isset($headers['X-Admin-Password']) ? $headers['X-Admin-Password'] : '';

    // !!! NEVER HARDCODE PASSWORDS LIKE THIS IN PRODUCTION !!!
    // Use environment variables or a secure configuration file.
    $expected_password = 'your_strong_admin_password_here'; // CHANGE THIS!

    if ($auth_header === $expected_password) {
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!authenticate()) {
        http_response_code(401); // Unauthorized
        echo json_encode(['success' => false, 'message' => 'Authentication failed.']);
        exit;
    }

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $service = $data['service'] ?? null;
    $status = $data['status'] ?? null;
    $message = $data['message'] ?? null;

    if ($service === 'roblox' && $status && $message) {
        $statusFilePath = 'status.json';

        // Read existing status data
        $currentStatus = [];
        if (file_exists($statusFilePath)) {
            $currentStatus = json_decode(file_get_contents($statusFilePath), true);
        }

        // Update the Roblox status
        $currentStatus['roblox'] = [
            'status' => $status,
            'message' => $message,
            'timestamp' => date('c') // ISO 8601 format
        ];

        // Write updated status back to file
        if (file_put_contents($statusFilePath, json_encode($currentStatus, JSON_PRETTY_PRINT))) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Failed to write status file.']);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Only POST requests are allowed.']);
}
?>
