<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    txt
    <?php include 'partials/header.php'; ?>

    <?php
    include 'db.php';
    foreach ($tasks as $task) {
        echo "<div class='task'>
            <h3>" . htmlspecialchars($task['title']) . "</h3>
            <p>" . htmlspecialchars($task['description']) . "</p>
            <span>Status: " . htmlspecialchars($task['status']) . "</span>
          </div>";
    }
    ?>

    <?php include 'partials/footer.php'; ?>
</body>

</html>