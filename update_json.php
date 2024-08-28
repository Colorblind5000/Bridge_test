<?php
// API URL and Key
$url = 'https://dsa-prd-sharedservices-api.azure-api.net/marselisborg/apsis-jobs';
$apiKey = '1155a9ca7acf4979842f2e7cd699f163';

// Setup cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: ' . $apiKey
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL session
$response = curl_exec($ch);
if (curl_errno($ch)) {
    throw new Exception(curl_error($ch));
}

// Close cURL session
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

// Assuming the API returns an array of job entries, adjust as needed
$transformedData = array_map(function ($item) {
    return [
        'occupationName' => $item['occupationName'], // Adjust key names based on actual API response
        'companyJobId' => $item['companyJobId'],
        'filterOption' => $item['filterOption'], // Adjust as needed if API includes these fields
        'comment' => $item['comment'],
        'id' => $item['id'],
        'presentation' => $item['presentation'] // Adjust handling of HTML content if necessary
    ];
}, $data);

// Encode data back to JSON
$jsonData = json_encode($transformedData, JSON_PRETTY_PRINT);

// Specify the path to save the JSON file
$jsonFilePath = '/path/to/your/directory/dynamicContent.json'; // Change this to your actual path

// Save to file
file_put_contents($jsonFilePath, $jsonData);

echo "JSON file has been updated.";
?>
