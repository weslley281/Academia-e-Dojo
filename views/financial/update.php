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
            <div class="col"><a href="./index.php?page=martial_arts" class="btn btn-light float-right">Cancelar</a></div>
        </div>


    </form>
</div>

<script src="./libs/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea#description',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        language: 'pt_BR',
    });
</script>