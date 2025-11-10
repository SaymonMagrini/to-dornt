<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Lista de Tarefas</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 700px;
      margin: 40px auto;
      background-color: #f7f7f7;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }

    h2, h3 {
      color: #333;
      text-align: center;
    }

    form {
      margin-bottom: 15px;
      text-align: center;
    }

    input[type="text"], select {
      padding: 6px;
      margin: 4px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      padding: 6px 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      background: white;
      margin: 8px 0;
      padding: 10px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    li small {
      color: #666;
      margin-left: 5px;
    }

    li form {
      display: inline;
      margin: 0;
    }

    a {
      color: #007bff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .logout {
      display: block;
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <h2>Olá, <?= htmlspecialchars($user['name'] ?? 'Usuário') ?>!</h2>
  <p style="text-align:center;">Bem-vindo à sua lista de tarefas.</p>

  <form method="POST" action="/tasks/store">
    <input type="text" name="title" placeholder="Nova tarefa" required>
    <select name="category_id">
      <option value="">Categoria</option>
      <?php foreach ($categories as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
    <input type="text" name="tags" placeholder="Tags (separe por vírgula)">
    <button type="submit">Adicionar</button>
  </form>

  <h3>Suas Tarefas</h3>
  <ul>
    <?php if (empty($tasks)): ?>
      <li>Nenhuma tarefa encontrada.</li>
    <?php else: ?>
      <?php foreach ($tasks as $t): ?>
        <li>
          <div>
            <form method="POST" action="/tasks/toggle/<?= $t['id'] ?>" style="display:inline;">
              <button type="submit"><?= $t['done'] ? '✅' : '⬜' ?></button>
            </form>

            <strong><?= htmlspecialchars($t['title']) ?></strong>

            <?php if (!empty($t['category_name'])): ?>
              <small>[<?= htmlspecialchars($t['category_name']) ?>]</small>
            <?php endif; ?>

            <?php if (!empty($t['tags'])): ?>
              <small>Tags: <?= htmlspecialchars($t['tags']) ?></small>
            <?php endif; ?>
          </div>

          <form method="POST" action="/tasks/delete/<?= $t['id'] ?>" style="display:inline;">
            <button type="submit" style="background-color: #dc3545;">🗑️</button>
          </form>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>
  </ul>

  <a class="logout" href="/auth/logout">Sair</a>
</body>
</html>
