<?php $this->layout('layouts/base', ['title' => 'Editar Tarefa']) ?>

<h2>Editar Tarefa</h2>

<form method="POST" action="/admin/tasks/edit?id=<?= $task['id'] ?>">
    <input type="text" name="title" class="input-texto" value="<?= htmlspecialchars($task['title']) ?>" required>

    <textarea name="description" class="input-texto"><?= htmlspecialchars($task['description']) ?></textarea>

    <select name="category_id" class="input-texto">
        <option value="">Selecione a categoria</option>
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $task['category_id'] == $c['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <p>Tags:</p>
    <?php foreach ($tags as $tag): ?>
        <label>
            <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>"
                <?= in_array($tag['id'], $task['tags']) ? 'checked' : '' ?>>
            <?= htmlspecialchars($tag['name']) ?>
        </label><br>
    <?php endforeach; ?>

    <button type="submit" class="btn">Salvar alterações</button>
</form>
