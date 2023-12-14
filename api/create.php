<?php
// Headers for CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle OPTIONS request method for CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// Check if the Request Method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(array('message' => 'Method Not Allowed'));
    return;
}

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate a Database object & connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate Bookmark object
$bookmark = new Bookmark($dbConnection);

// Get the HTTP POST request JSON body
$data = json_decode(file_get_contents("php://input"), true);

// Validate the input
if (!$data || !isset($data['title']) || !isset($data['link'])) {
    http_response_code(400);
    echo json_encode(array('message' => 'Bad Request: Missing title or link'));
    return;
}

// Set title and link in the Bookmark object
$bookmark->setTitle($data['title']);
$bookmark->setLink($data['link']);

// Attempt to create the Bookmark
try {
    if ($bookmark->create()) {
        http_response_code(201);
        echo json_encode(array('message' => 'Bookmark created successfully'));
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Bookmark could not be created'));
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array('message' => 'Database error: ' . $e->getMessage()));
}
?>