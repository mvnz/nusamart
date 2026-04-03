<?php
// Read API key directly from .env
$envContent = file_get_contents(__DIR__ . '/.env');
preg_match('/BINDERBYTE_API_KEY=([^\r\n]+)/', $envContent, $matches);
$key = trim($matches[1] ?? '');

echo "API Key: " . $key . PHP_EOL;
echo "Key length: " . strlen($key) . PHP_EOL;

$awb = '541980014107625';
$url = "https://api.binderbyte.com/v1/track?api_key=" . urlencode($key) . "&courier=auto&awb=" . urlencode($awb);

echo "Calling: " . $url . PHP_EOL . PHP_EOL;

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HEADER => true,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "cURL Error: " . $error . PHP_EOL;
} else {
    $body = substr($response, $headerSize);
    echo "HTTP Status: " . $httpCode . PHP_EOL;
    echo "Body: " . $body . PHP_EOL;
}
