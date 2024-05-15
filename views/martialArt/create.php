<div class="container mt-5">
    <h1>Criar Arte Marcial</h1>
    <form action="./controllers/MartialArtController.php?action=create" method="post" class="form-group">
        <div class="mb-3 form-group">
            <label for="name" class="form-label"><strong>Nome:</strong></label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label"><strong>Descrição:</strong></label>
            <textarea name="description" id="description" class="form-control" cols="30" rows="5" maxlength="500" minlength="5" required></textarea>
        </div>

        <div class="row">
            <div class="col"><button type="submit" class="mb-3 btn btn-success float-left">Criar</button></div>
            <div class="col"><a href="./index.php?page=martialArts" class="btn btn-light float-right">Cancelar</a></div>
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