<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Autenticação' ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<div class="container">

    <?php foreach (\App\Core\Flash::pullAll() as $f): ?>
        <div class="flash flash-<?= $f['type'] ?>">
            <?= htmlspecialchars($f['message']) ?>
        </div>
    <?php endforeach; ?>

    <?echo ($content) ?>
</div>

</body>
</html>
