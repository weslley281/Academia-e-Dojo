<?php include '../partials/header.php'; ?>

<div class="container mt-5">
    <h1>Criar Usuário</h1>
    <form action="../../index.php?action=create" method="post" class="form-group">
        <div class="mb-3">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Criar</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>