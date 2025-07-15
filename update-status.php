<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['service']) || !isset($input['status']) || !isset($input['message'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
        exit;
    }
    
    $service = $input['service'];
    $status = $input['status'];
    $message = $input['message'];
    
    // Load existing status
    $statusFile = 'status.json';
    if (file_exists($statusFile)) {
        $currentStatus = json_decode(file_get_contents($statusFile), true);
    } else {
        $currentStatus = [
            'roblox' => [
                'status' => 'down',
                'message' => 'Service down',
                'timestamp' => date('c')
            ],
            'website' => [
                'status' => 'up',
                'message' => 'All systems operational',
                'timestamp' => date('c')
            ]
        ];
    }
    
    // Update the specific service
    if (isset($currentStatus[$service])) {
        $currentStatus[$service]['status'] = $status;
        $currentStatus[$service]['message'] = $message;
        $currentStatus[$service]['timestamp'] = date('c');
        
        // Save back to file
        if (file_put_contents($statusFile, json_encode($currentStatus, JSON_PRETTY_PRINT))) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save status']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid service']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
