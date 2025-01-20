<?php

// Function to replace placeholders in the template with actual data
function renderTemplate($template, $data) {
    foreach ($data as $key => $value) {
        if (is_array($value)) continue; // Skip arrays for now
        $template = str_replace("{{" . $key . "}}", $value, $template);
    }
    return $template;
}

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

// Read the template file
$template = file_get_contents('receipt.html');

$transaction = json_decode($payload, true);
// Prepare items HTML
$itemsHtml = '';
foreach ($transaction['items'] as $item) {
    $itemTotal = number_format($item['quantity'] * $item['sell'], 2);
    $itemsHtml .= "<tr>
        <td>{$item['name']}</td>
        <td>{$item['quantity']}</td>
        <td>$" . number_format($item['sell'], 2) . "</td>
        <td>$" . $itemTotal . "</td>
    </tr>";
}

// Prepare payment details
$payment = $transaction['payment'][0];

// Create the data array to replace in the template
$data = [
    'transactionId' => $transaction['transactionId'],
	'memberId' => $transaction['memberId'],
	'memberName' => $transaction['memberName'],
    'datetime' => $transaction['datetime'],
    'items' => $itemsHtml,
    'amount' => number_format($transaction['amount'], 2),
    'paymentType' => $payment['type'],
    'tendered' => number_format($payment['tendered'], 2),
    'change' => number_format($payment['change'], 2)
];

// Render the template
$output = renderTemplate($template, $data);

// Save the output to a file
$outputFile = 'data/receipts/' . $transaction['transactionId'] . '.html';
file_put_contents($outputFile, $output);

// Construct the full URL to the receipt file
$fullUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/4e35ce7b-c95c-42c2-811a-fe1968245d18/f7033837-3dd8-4bd8-9962-db9469f859f3/' . $outputFile;

// Return the URL in the JSON response
echo json_encode([
    'status' => 'success',
    'receiptUrl' => $fullUrl
]);
?>
