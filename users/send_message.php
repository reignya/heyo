<?php
// Include the database connection
include('../DBconnection/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = $input['message'] ?? '';

    // Validate message
    if (empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Message cannot be empty.']);
        exit;
    }

    // Prepare and execute the SQL statement to save the message
    $stmt = $con->prepare("INSERT INTO messages (username, message, isSupport) VALUES (?, ?, ?)");
    $isSupport = 0; // 0 for user messages
    $username = 'User'; // Change to the actual username or get it from session
    $stmt->bind_param("ssi", $username, $message, $isSupport);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send message.']);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
