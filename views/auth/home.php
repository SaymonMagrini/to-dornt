<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
</head>
<body>
  <h2>Bem-vindo à sua lista de tarefas!</h2>

  <?php
  use App\Core\Flash;
  foreach (Flash::getAll() as $msg): ?>
    <p style="color: green;"><?= htmlspecialchars($msg['message']) ?></p>
  <?php endforeach; ?>

  <p>Você está logado. Agora pode acessar suas tarefas.</p>

  <a href="/logout.php">Sair</a>
</body>
</html>
