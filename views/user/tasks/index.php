<?php include __DIR__ . '/../../layout/header.php'; ?>
<div class="container">
  <h2 style="text-align:center">Olá, <?= htmlspecialchars($user['name']) ?></h2>

  <form method="POST" action="/?p=tasks/store">
    <input class="input" name="title" placeholder="Nova tarefa" required>
    <textarea class="input" name="description" placeholder="Descrição (opcional)"></textarea>

    <label style="color:#fff">Categorias (segure Ctrl / selecione múltiplas):</label>
    <select class="input" name="categories[]" multiple size="4">
      <?php foreach($categories as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
      <?php endforeach; ?>
    </select>

    <button class="btn">Adicionar</button>
  </form>

  <h3 style="margin-top:20px;color:#00FFFF">Suas Tarefas</h3>
  <table class="table">
    <tr style="background:#303030"><th>ID</th><th>Título</th><th>Categorias</th><th>Concluída</th><th>Ações</th></tr>
    <?php if (empty($tasks)): ?>
      <tr><td colspan="5">Nenhuma tarefa encontrada.</td></tr>
    <?php else: foreach($tasks as $t): ?>
      <tr>
        <td><?= $t['id'] ?></td>
        <td><?= htmlspecialchars($t['title']) ?></td>
        <td><?= htmlspecialchars($t['categories'] ?? '') ?></td>
        <td><?= $t['done'] ? 'Sim' : 'Não' ?></td>
        <td>
          <a href="/?p=tasks/toggle&id=<?= $t['id'] ?>" style="color:#00FFFF">Toggle</a> |
          <a href="/?p=tasks/delete&id=<?= $t['id'] ?>" style="color:#ff6666">Excluir</a>
        </td>
      </tr>
    <?php endforeach; endif; ?>
  </table>
</div>
<?php include __DIR__ . '/../../layout/footer.php'; ?>
