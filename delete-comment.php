<?php
require "config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Debugging
    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID is empty.']);
        exit;
    }

    // Use prepared statements to prevent SQL injection
    $delete = $conn->prepare("DELETE FROM comments WHERE id = :id");
    $delete->bindParam(':id', $id, PDO::PARAM_INT); // Bind parameter

    if ($delete->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Comment deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete comment.', 'error' => $delete->errorInfo()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
