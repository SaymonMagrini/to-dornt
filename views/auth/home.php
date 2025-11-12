<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Lista de Tarefas</title>
  <link rel="stylesheet" href="/assets/style.css">
</head>

<body>

  <div class="header">
    <a href="/home" class="header__itm">Home</a>
    <a href="/tasks" class="header__itm">Tarefas</a>
    <a href="/logout" class="header__itm">Sair</a>
  </div>

  <div class="container">
    <h2 class="titulo">Olá, <?= htmlspecialchars($user['name'] ?? 'Usuário') ?>!</h2>
    <p style="text-align:center;">Bem-vindo à sua lista de tarefas.</p>

    <form method="POST" action="/tasks/store">
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

    <h3>Suas Tarefas</h3>
    <ul>
      <?php if (empty($tasks)): ?>
        <li>Nenhuma tarefa encontrada.</li>
      <?php else: ?>
        <?php foreach ($tasks as $t): ?>
          <li>
            <div>
              <?= $t['done'] ? '✅' : '⬜' ?>
              <strong><?= htmlspecialchars($t['title']) ?></strong>
              <?php if (!empty($t['category_name'])): ?>
                <small>[<?= htmlspecialchars($t['category_name']) ?>]</small>
              <?php endif; ?>
              <?php if (!empty($t['tags'])): ?>
                <small>Tags: <?= htmlspecialchars($t['tags']) ?></small>
              <?php endif; ?>
            </div>
            <form method="POST" action="/tasks/delete/<?= $t['id'] ?>">
              <button type="submit" style="background:none;border:none;color:#00ffff;cursor:pointer;">🗑</button>
            </form>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
</body>

</html>