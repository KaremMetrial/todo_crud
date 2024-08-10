<?php
include "includes/header.php";
include "conn.php";
?>
<div class="container">
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <h1 class="my-4">Todo List</h1>

    <form action="insert.php" method="post" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="task" placeholder="Enter Task" aria-label="Enter Task" required>
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>

    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Task Name</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $stmt = $conn->query("SELECT * FROM tasks");
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($tasks as $row) :
                ?>
                <tr>
                    <th scope="row"><?= htmlspecialchars($row['id']); ?></th>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td>
                        <a href="update.php?id=<?= htmlspecialchars($row['id']); ?>" title="Edit Task">
                            <button type="button" class="btn btn-success">Edit</button>
                        </a>
                        <a href="delete.php?id=<?= htmlspecialchars($row['id']); ?>" title="Delete Task"
                           onclick="return confirm('Are you sure you want to delete this task?');">
                            <button type="button" class="btn btn-danger">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php
        } catch (PDOException $e) {
            echo '<tr><td colspan="3">Error fetching tasks: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?php
include "includes/footer.php";
?>
