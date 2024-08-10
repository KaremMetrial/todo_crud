<?php
require "conn.php";

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    try {
        $id = (int)$_GET['id'];
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php?message=' . urlencode('Task deleted successfully!'));
        exit();
    } catch (PDOException $e) {
        header('Location: index.php?message=' . urlencode('An error occurred while deleting the task.'));
        exit();
    }
} else {
    header('Location: index.php?message=' . urlencode('Invalid task ID.'));
    exit();
}