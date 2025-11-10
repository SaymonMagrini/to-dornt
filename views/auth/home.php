<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Lista de Tarefas</title>
  <link rel="stylesheet" href="/beta/assets/style.css">
</head>
<body>

  <div class="header">
    <a href="/home" class="header__itm">Home</a>
    <a href="/tasks" class="header__itm">Tarefas</a>
    <a href="/logout" class="header__itm">Sair</a>
  </div>

  <div class="container">
    <h2 class="titulo">Olá, <?= htmlspecialchars($user['name'] ?? 'Usuário') ?>!</h2>
    <p class="subtitulo">Bem-vindo à sua lista de tarefas.</p>

    <form method="POST" action="/tasks/store" class="form-tarefa">
      <input type="text" name="title" placeholder="Nova tarefa" required class="input-texto">
      
      <select name="category_id" class="input-select">
        <option value="">Categoria</option>
        <?php foreach ($categories as $c): ?>
          <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <input type="text" name="tags" placeholder="Tags (vírgula)" class="input-texto">
      <button type="submit" class="btn">Adicionar</button>
    </form>

    <h3 class="titulo-secundario">Suas Tarefas</h3>

    <ul class="lista-tarefas">
      <?php if (empty($tasks)): ?>
        <li class="item-tarefa">Nenhuma tarefa encontrada.</li>
      <?php else: ?>
        <?php foreach ($tasks as $t): ?>
          <li class="item-tarefa">
            <div>
              <form method="POST" action="/tasks/toggle/<?= $t['id'] ?>" class="form-inline">
                <button type="submit" class="btn-toggle"><?= $t['done'] ? '✅' : '⬜' ?></button>
              </form>

              <strong><?= htmlspecialchars($t['title']) ?></strong>

              <?php if (!empty($t['category_name'])): ?>
                <small class="categoria">[<?= htmlspecialchars($t['category_name']) ?>]</small>
              <?php endif; ?>

              <?php if (!empty($t['tags'])): ?>
                <small class="tags">Tags: <?= htmlspecialchars($t['tags']) ?></small>
              <?php endif; ?>
            </div>

            <form method="POST" action="/tasks/delete/<?= $t['id'] ?>" class="form-inline">
              <button type="submit" class="btn-delete"></button>
            </form>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
</body>
</html>
