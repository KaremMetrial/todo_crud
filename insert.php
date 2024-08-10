<?php
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['task']) && !empty($_POST['task'])) {
        $task = trim($_POST['task']);

        try {
            $stmt = $conn->prepare("INSERT INTO tasks (name) VALUES (:task)");
            $stmt->bindParam(':task', $task);
            $stmt->execute();
            header('Location: index.php?message=' . urlencode('Task added successfully!'));
            exit();
        } catch (PDOException $e) {
            header('Location: index.php?message=' . urlencode('An error occurred. Please try again.'));
            exit();
        }
    } else {
        header('Location: index.php?message=' . urlencode('Task cannot be empty!'));
        exit();
    }
}
