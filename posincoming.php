;<?php
//posincoming.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'retailcentral.com.au';
$db   = 'RetailCentral_Star';
$user = 'appconnect';
$pass = '@Runner01';
$charset = 'utf8mb4';

$incomingFolderPath = __DIR__ . '\\data\\incoming\\';
$processedFolderPath = __DIR__ . '\\data\\processed\\';

echo $incomingFolderPath . '<br>';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$files = scandir($incomingFolderPath);

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === "pos") {
        $content = file_get_contents($incomingFolderPath . $file);

        echo $content . '<br>';

        // Clean and fix the JSON content
       // $content = fixMalformedJson($content);
		
		//        echo $content . '<br>';
				


        $transaction = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Error decoding JSON: " . json_last_error_msg() . "<br>";
            continue;
        }

        $utcDateTimeString = $transaction['datetime'];
        echo "Original datetime from .pos file: " . $utcDateTimeString . "<br>";

        $utcDateTime = new DateTime($utcDateTimeString, new DateTimeZone('UTC'));
        $localTimezone = new DateTimeZone('Australia/Brisbane');
        $utcDateTime->setTimezone($localTimezone);
        $mysqlFormattedDateTime = $utcDateTime->format('Y-m-d H:i:s');

        if ($transaction) {
            $stmt = $pdo->prepare("
                INSERT INTO POSTransactions 
                (POSID, TransactionID, DateTimeTransaction, ContactID, SalesExTax, TaxAmount, SalesIncTax, TenderData, ItemCount, RawData, Response, Authorization) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $transaction['posId'], 
                $transaction['transactionId'],
                $mysqlFormattedDateTime,
                $transaction['memberId'],
                $transaction['amount'],
                $transaction['amount'],
                $transaction['amount'],
                json_encode($transaction['payment']), 
                count($transaction['items']),
                $content,
                $transaction['payment'][0]['status'],
                $transaction['payment'][0]['authorization']
            ]);

            $stmt = $pdo->prepare("
                INSERT INTO LocationItemTransaction
                (DeviceID, TransactionID, DateTimeTransaction, ItemCount, ValueExTax, ValueTax, ValueIncTax, RawData) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $transaction['posId'], 
                $transaction['transactionId'],
                $mysqlFormattedDateTime,
                count($transaction['items']),
                $transaction['amount'],
                $transaction['amount'],
                $transaction['amount'],
                $content
            ]);

            // Once processed, move the file to the processed directory
            rename($incomingFolderPath . $file, $processedFolderPath . $file);
        }
    }
}

echo 'Done';

function fixMalformedJson($json) {
    // Check if the JSON contains the word "CARD"
    if (strpos($json, '"type":"CARD"') !== false) {
        // Perform the replacements
        $json = str_replace('"payment"', '"amount"', $json);    
        $json = str_replace('"items"', '"payment"', $json);
        $json = str_replace('"memberName":', '"items":', $json);
    }
    
    return $json;
}


?>
