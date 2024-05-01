<div class="container mt-5 mb-5">
    <h1>Deletar Usuário</h1>
    <div class="alert alert-danger" role="alert">
        <p>Você tem certeza que deseja deletar o usuáro <strong>"<?php echo $user["name"] ?></strong>"</p>
    </div>

    <form action="./controllers/UserController.php?action=delete" method="post" class="form-group">
        <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="./index.php?page=users" class="btn btn-light">Cancelar</a>
    </form>
</div>