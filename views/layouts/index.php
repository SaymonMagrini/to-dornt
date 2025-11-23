<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Painel' ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>

<body>

    <div class="header">
        <a href="/admin" class="header__itm">Dashboard</a>
        <a href="/admin/tasks" class="header__itm">Tarefas</a>
        <a href="/admin/categories" class="header__itm">Categorias</a>
        <a href="/admin/tags" class="header__itm">Tags</a>
        <a href="/logout" class="header__itm">Sair</a>
    </div>

    <div class="container">

        <?php foreach (\App\Core\Flash::pullAll() as $f): ?>
            <div class="flash flash-<?= $f['type'] ?>">
                <?= htmlspecialchars($f['message']) ?>
            </div>
        <?php endforeach; ?>

        <? echo ($content) ?>
    </div>

</body>

</html>