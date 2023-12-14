<?php
// Headers for CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Respond to CORS preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// Proceed only if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
    header('Allow: PUT');
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
    exit();
}

// Include necessary files
include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate Database object and connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate Bookmark object
$bookmark = new Bookmark($dbConnection);

// Get the data from the request
$data = json_decode(file_get_contents("php://input"));

// Validate the data
if (!$data || !isset($data->id) || !isset($data->link)) {
    http_response_code(422);
    echo json_encode(['message' => 'Missing required parameters id and link.']);
    exit();
}

// Set the ID and link of the Bookmark
$bookmark->setId($data->id);
$bookmark->setLink($data->link);

// Attempt to update the Bookmark
if ($bookmark->update()) {
    echo json_encode(['message' => 'Bookmark updated.']);
} else {
    echo json_encode(['message' => 'Bookmark update failed.']);
}
?>