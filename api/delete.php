<?php
// Headers for CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Respond to CORS preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit();
}

// Proceed only if the request method is DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header('Allow: DELETE');
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Method Not Allowed']);
    exit();
}

require_once '../db/Database.php';
require_once '../models/Bookmark.php';

// Instantiate Database object and connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate Bookmark object
$bookmark = new Bookmark($dbConnection);

// Get the data from the request
$data = json_decode(file_get_contents("php://input"));

// Validate the data
if (empty($data) || !isset($data->id)) {
    http_response_code(422); // Unprocessable Entity
    echo json_encode(['message' => 'Error: Missing required parameter id in the JSON body.']);
    exit();
}

// Set the ID of the Bookmark to delete
$bookmark->setId($data->id);

// Attempt to delete the Bookmark
if ($bookmark->delete()) {
    echo json_encode(['message' => 'Bookmark deleted successfully.']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Error: Bookmark could not be deleted.']);
}
?>