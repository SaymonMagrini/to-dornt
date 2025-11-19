<?php $this->layout('layouts/base', ['title' => 'Editar Categoria']) ?>

<h2>Editar Categoria</h2>

<form method="POST" action="/admin/categories/edit?id=<?= $category['id'] ?>">
    <input type="text" name="name" class="input-texto" value="<?= htmlspecialchars($category['name']) ?>" required>
    <button type="submit" class="btn">Salvar</button>
</form>
