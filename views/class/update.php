<?php
$get_martialart = $martialart->getById($class["idMartialArt"]);
$get_instructor = $user->getById($class["idInstructor"]);
?>
<div class="container mt-5">
    <h1>Editar Turma</h1>
    <form action="./controllers/ClassController.php?action=update" method="post"> <!-- Ação do formulário -->
        <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
        <div class="form-group form-group"> <!-- Campo para o nome da classe -->
            <label for="name" class="form-label"><strong>Nome:</strong></label>
            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($class['name']); ?>" required>
        </div>

        <div class="form-group"> <!-- Campo para a descrição da classe -->
            <label for="description" class="form-label"><strong>Descrição:</strong></label>
            <textarea name="description" id="description" class="form-control" cols="30" rows="5" required><?= htmlspecialchars($class['description']); ?></textarea>
        </div>

        <div class="form-group"> <!-- Campo para a descrição da classe -->
            <label for="value" class="form-label"><strong>Valor:</strong></label>
            <input type="text" id="value" name="value" value="<?= htmlspecialchars($class['value']); ?>" class="form-control" required>
        </div>

        <div class="form-group"> <!-- Campo para o ID da arte marcial associada -->
            <label for="idMartialArt" class="form-label"><strong>Arte Marcial:</strong></label>
            <select name="idMartialArt" class="form-control" id="idMartialArt">
                <option value="<?= htmlspecialchars($get_martialart["id"]); ?>"><?= htmlspecialchars($get_martialart["name"]); ?></option>
                <?php
                $martialarts = $martialart->getAll();

                if (isset($martialarts) && !empty($martialarts)) {
                    foreach ($martialarts as $martialart) {
                        if ($martialart['name'] != $get_martialart["name"]) {
                ?>
                            <option value="<?= htmlspecialchars($martialart['id']) ?>"><?= htmlspecialchars($martialart['name']) ?></option>
                <?php
                        }
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group"> <!-- Campo para o ID do instrutor associado -->
            <label for="idInstructor" class="form-label"><strong>Instrutor:</strong></label>
            <select class="form-control" name="idInstructor" id="idInstructor">
                <option value="<?= htmlspecialchars($get_instructor["id"]); ?>"><?= htmlspecialchars($get_instructor["name"]); ?></option>
                <?php
                $users = $user->getAllInstructors();

                if (isset($users) && !empty($users)) {
                    foreach ($users as $instructor) {
                        if ($instructor['name'] != $get_instructor["name"]) {
                ?>
                            <option value="<?= htmlspecialchars($instructor['id']) ?>"><?= htmlspecialchars($instructor['name']) ?></option>
                <?php
                        }
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group"> <!-- Campo para a hora inicial da classe -->
            <label for="initialHour" class="form-label"><strong>Hora Inicial:</strong></label>
            <input type="time" id="initialHour" name="initialHour" class="form-control" value="<?= htmlspecialchars($class['initialHour']); ?>" required>
        </div>

        <div class="form-group"> <!-- Campo para a hora final da classe -->
            <label for="finalHour" class="form-label"><strong>Hora Final:</strong></label>
            <input type="time" id="finalHour" name="finalHour" class="form-control" value="<?= htmlspecialchars($class['finalHour']); ?>" required>
        </div>

        <div class="form-group row"> <!-- Botões para submeter ou cancelar -->
            <div class="col">
                <button type="submit" class="mb-3 btn btn-secondary float-left">
                    Salvar
                </button> <!-- Botão de criação -->
            </div>
            <div class="col">
                <a href="./index.php?page=classes" class="mb-3 btn btn-light float-right"><i class="fa-solid fa-xmark"></i> Cancelar</a> <!-- Link para cancelar -->
            </div>
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