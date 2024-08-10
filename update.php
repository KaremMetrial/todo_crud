<?php
include "includes/header.php";
require "conn.php";

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = (int)$_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
        $task = trim($_POST['task']);

        if (!empty($task)) {
            try {
                $stmt = $conn->prepare("UPDATE tasks SET name = :task WHERE id = :id");
                $stmt->bindParam(':task', $task);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                $stmt->execute();

                header('Location: index.php?message=' . urlencode('Task updated successfully!'));
                exit();
            } catch (PDOException $e) {
                header('Location: index.php?message=' . urlencode('An error occurred while updating the task.'));
                exit();
            }
        } else {
            header('Location: index.php?message=' . urlencode('Task cannot be empty.'));
            exit();
        }
    } else {
        try {
            // Fetch the current task data
            $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $task = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$task) {
                header('Location: index.php?message=' . urlencode('Task not found.'));
                exit();
            }
        } catch (PDOException $e) {
            header('Location: index.php?message=' . urlencode('Error fetching task.'));
            exit();
        }
    }
} else {
    header('Location: index.php?message=' . urlencode('Invalid request.'));
    exit();
}
?>

<?php
include "includes/header.php";
?>

<div class="container">
    <h1 class="my-4">Update Task</h1>
    <form action="update.php?id=<?= htmlspecialchars($id) ?>" method="post" class="mb-3">
        <div class="mb-3">
            <label for="task" class="form-label">Task Name</label>
            <input type="text" class="form-control" id="task" name="task" value="<?= htmlspecialchars($task['name']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</div>
<?php
include "includes/footer.php";