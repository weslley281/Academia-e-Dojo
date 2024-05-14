<div class="container mt-5 mb-5">
    <h1>Deletar Classe</h1>
    <div class="alert alert-danger" role="alert">
        <p>Você tem certeza que deseja deletar essa classe <strong>"<?php echo $martialart["name"] ?></strong>"</p>
    </div>

    <form action="./controllers/MartialArtController.php?action=delete" method="post" class="form-group">
        <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="./index.php?page=martialarts" class="btn btn-light">Cancelar</a>
    </form>
</div>