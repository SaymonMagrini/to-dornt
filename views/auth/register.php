<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Lista de Tarefas</title>
  <style>
    body {
      background-color: #0C0C0C;
      color: #FFFFFF;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #303030;
      display: flex;
      justify-content: left;
      align-items: center;
      padding: 10px;
    }

    .header__itm {
      color: #FFFFFF;
      background-color: #303030;
      font-weight: 700;
      text-decoration: none;
      padding: 10px 15px;
      border: 2px solid #00ffff;
      margin: 5px;
      border-radius: 8px;
    }

    .header__itm:hover {
      background-color: #00ffff;
      color: #000;
    }

    .container {
      padding: 20px;
      max-width: 600px;
      margin: 40px auto;
      background-color: #1a1a1a;
      border-radius: 10px;
      box-shadow: 0 0 10px #00ffff33;
    }

    .titulo {
      text-align: center;
      margin-bottom: 15px;
    }

    .input-texto, .input-select {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 2px solid #00ffff;
      border-radius: 6px;
      background-color: #0C0C0C;
      color: #FFFFFF;
    }

    .btn {
      width: 100%;
      padding: 10px;
      background-color: #00ffff;
      border: none;
      border-radius: 6px;
      color: #000;
      font-weight: bold;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #00cccc;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      background-color: #222;
      margin-bottom: 8px;
      padding: 10px;
      border-radius: 6px;
      border-left: 4px solid #00ffff;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    small {
      color: #00cccc;
    }

    a {
      color: #00ffff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
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
