<?php
// Include the database connection
include('../DBconnection/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if user_id is provided in the query string
    if (isset($_GET['user_id'])) {
        $userId = (int)$_GET['user_id']; // Cast to integer for security
        $stmt = $con->prepare("SELECT username, message, isSupport FROM messages WHERE user_id = ? ORDER BY created_at ASC");
        $stmt->bind_param("i", $userId); // Bind the user_id parameter
    } else {
        // Fetch all messages if no user_id is specified
        $stmt = $con->prepare("SELECT username, message, isSupport FROM messages ORDER BY created_at ASC");
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode(['success' => true, 'messages' => $messages]);
    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
