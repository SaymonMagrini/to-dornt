<?php $this->layout('layouts/base', ['title' => 'Criar Categoria']) ?>

<h2>Nova Categoria</h2>

<form method="POST" action="/admin/categories/create">
    <input type="text" name="name" class="input-texto" placeholder="Nome da categoria" required>
    <button type="submit" class="btn">Salvar</button>
</form>
