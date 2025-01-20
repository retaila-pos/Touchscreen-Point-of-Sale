<?php
header('Content-Type: application/json'); // Set header to ensure the response is seen as JSON

// Ensure we're handling a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
    exit;
}


// Folder path
$incomingFolderPath = __DIR__ . '/data/incoming/';

// Get the payload from POST
$payload = file_get_contents('php://input');

// Check if payload is valid JSON
$jsonPayload = json_decode($payload, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON payload.'
    ]);
    exit;
}

// Check if 'transactionId' exists in the payload
if (!isset($jsonPayload['transactionId'])) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing transactionId in the payload.'
    ]);
    exit;
}

// Use the transactionId for the filename
$filename = $incomingFolderPath . $jsonPayload['transactionId'] . '.pos';

// Check if a file with that name already exists
if (file_exists($filename)) {
    http_response_code(409); // Conflict
    echo json_encode([
        'status' => 'error',
        'message' => 'A transaction with this ID already exists.'
    ]);
    exit;
}

// Save the payload to the file
if (file_put_contents($filename, $payload)) {
    http_response_code(200); // OK
    echo json_encode([
        'status' => 'success',
        'message' => 'Transaction successfully saved.'
    ]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'status' => 'error',
        'message' => 'Error saving the transaction.'
    ]);
}





?>
