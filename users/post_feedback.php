<?php
// Include the database connectionerror_reporting(E_ALL);
ini_set('display_errors', 1);

include('../DBconnection/dbconnection.php');

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : 'Anonymous'; // Default to 'Anonymous'
    $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';

    // Validate feedback
    if (empty($feedback)) {
        echo json_encode(['success' => false, 'message' => 'Feedback cannot be empty.']);
        exit;
    }

    // Prepare and execute the SQL statement
    $stmt = $con->prepare("INSERT INTO feedbacks (username, feedback) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $feedback);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit feedback.']);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
