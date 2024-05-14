<div class="container mt-5">
    <h1>Editar Arte Marcial</h1>
    <form action="./controllers/MartialArtController.php?action=update" method="post" class="form-group">
        <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
        <div class="mb-3 form-group">
            <label for="name" class="form-label"><strong>Nome:</strong></label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $martialart["name"] ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label"><strong>Descrição:</strong></label>
            <textarea name="description" id="description" class="form-control" cols="30" rows="5" maxlength="500" minlength="5" required><?php echo $martialart["description"] ?></textarea>
        </div>

        <div class="row">
            <div class="col"><button type="submit" class="mb-3 btn btn-secondary float-left">Salvar</button></div>
            <div class="col"><a href="./index.php?page=martialArts" class="btn btn-light float-right">Cancelar</a></div>
        </div>


    </form>
</div>