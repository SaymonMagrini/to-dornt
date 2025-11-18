<?php include __DIR__ . '/../../layout/header.php'; ?>
<div class="container">
  <h2 style="color:#00FFFF">Editar Tarefa</h2>
  <?php if (empty($task)): echo '<p>Tarefa não encontrada</p>'; else: ?>
  <form method="POST" action="/?p=admin/tasks/update">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input type="hidden" name="id" value="<?= $task['id'] ?>">
    <input class="input" name="title" value="<?= htmlspecialchars($task['title']) ?>">
    <textarea class="input" name="description"><?= htmlspecialchars($task['description'] ?? '') ?></textarea>
    <label style="color:#fff">Categorias:</label>
    <select class="input" name="categories[]" multiple size="6">
      <?php foreach($categories as $c): ?>
        <?php
          $sel = false;
          foreach($assigned as $a) if ($a['id']==$c['id']) $sel = true;
        ?>
        <option value="<?= $c['id'] ?>" <?= $sel ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
    <label style="display:block;color:#fff"><input type="checkbox" name="done" value="1" <?= $task['done'] ? 'checked' : '' ?>> Concluída</label>
    <button class="btn">Salvar</button>
  </form>

  <form method="POST" action="/?p=admin/tasks/delete" style="margin-top:10px;">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input type="hidden" name="id" value="<?= $task['id'] ?>">
    <button style="background:#ff6666;color:#fff;padding:8px;border:none;border-radius:6px">Excluir</button>
  </form>
  <?php endif; ?>
</div>
<?php include __DIR__ . '/../../layout/footer.php'; ?>
