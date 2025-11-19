<?php $this->layout('layouts/base', ['title' => 'Criar Tarefa']) ?>

<h2>Nova Tarefa</h2>

<form method="POST" action="/admin/tasks/create">
    <input type="text" name="title" class="input-texto" placeholder="Título" required>

    <textarea name="description" class="input-texto" placeholder="Descrição"></textarea>

    <select name="category_id" class="input-texto">
        <option value="">Selecione a categoria</option>
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <p>Tags:</p>
    <?php foreach ($tags as $tag): ?>
        <label>
            <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>">
            <?= htmlspecialchars($tag['name']) ?>
        </label><br>
    <?php endforeach; ?>

    <button type="submit" class="btn">Salvar</button>
</form>
