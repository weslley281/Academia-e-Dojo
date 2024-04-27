<div class="container mt-5">
    <h1>Deletar Usuário</h1>
    <p>Você tem certeza que deseja deletar o usuáro <?php echo $user["name"] ?></p>
    <form action="./user.php?action=delete" method="post" class="form-group">
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="./index.php?page=users" class="btn btn-light">Cancelar</a>
    </form>
</div>