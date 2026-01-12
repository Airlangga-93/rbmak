<?php

require_once 'vendor/autoload.php';

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    // Test Cloudinary connection
    $cloudName = $_ENV['CLOUDINARY_CLOUD_NAME'] ?? null;
    $apiKey = $_ENV['CLOUDINARY_API_KEY'] ?? null;
    $apiSecret = $_ENV['CLOUDINARY_API_SECRET'] ?? null;

    echo "Cloud Name: " . ($cloudName ? substr($cloudName, 0, 5) . "..." : "NOT SET") . "\n";
    echo "API Key: " . ($apiKey ? substr($apiKey, 0, 5) . "..." : "NOT SET") . "\n";
    echo "API Secret: " . ($apiSecret ? substr($apiSecret, 0, 5) . "..." : "NOT SET") . "\n";

    if (!$cloudName || !$apiKey || !$apiSecret) {
        echo "ERROR: Cloudinary credentials not properly configured in .env file\n";
        exit(1);
    }

    // Test upload
    echo "\nTesting Cloudinary upload...\n";
    $result = Cloudinary::upload(__DIR__ . '/public/favicon.ico', [
        'folder' => 'test',
        'public_id' => 'test_' . time()
    ]);

    echo "SUCCESS: Upload completed!\n";
    echo "Secure URL: " . $result->getSecurePath() . "\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
