<div class="container mt-5">
    <h1>Criar Turma</h1> <!-- Título da página -->
    <form action="./controllers/ClassController.php?action=create" method="post"> <!-- Ação do formulário -->
        <div class="form-group form-group"> <!-- Campo para o nome da classe -->
            <label for="name" class="form-label"><strong>Nome:</strong></label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group"> <!-- Campo para a descrição da classe -->
            <label for="description" class="form-label"><strong>Descrição:</strong></label>
            <textarea name="description" id="description" class="form-control" cols="30" rows="5" required></textarea>
        </div>

        <div class="form-group"> <!-- Campo para a descrição da classe -->
            <label for="value" class="form-label"><strong>Valor:</strong></label>
            <input type="text" id="value" name="value" class="form-control" required>
        </div>

        <div class="form-group"> <!-- Campo para o ID da arte marcial associada -->
            <label for="idMartialArt" class="form-label"><strong>Arte Marcial:</strong></label>
            <select name="idMartialArt" class="form-control" id="idMartialArt">
                <?php
                $martialarts = $martialart->getAll();

                if (isset($martialarts) && !empty($martialarts)) {
                    foreach ($martialarts as $martialart) {
                        $description = truncate($martialart['description'], 50);
                ?>
                        <option value="<?= htmlspecialchars($martialart['id']) ?>"><?= htmlspecialchars($martialart['name']) ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group"> <!-- Campo para o ID do instrutor associado -->
            <label for="idInstructor" class="form-label"><strong>Instrutor:</strong></label>
            <select class="form-control" name="idInstructor" id="idInstructor">
                <?php
                $users = $user->getAllInstructors();

                if (isset($users) && !empty($users)) {
                    foreach ($users as $instructor) {
                ?>
                        <option value="<?= htmlspecialchars($user['id']) ?>"><?= htmlspecialchars($instructor['name']) ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group"> <!-- Campo para a hora inicial da classe -->
            <label for="initialHour" class="form-label"><strong>Hora Inicial:</strong></label>
            <input type="time" id="initialHour" name="initialHour" class="form-control" required>
        </div>

        <div class="form-group"> <!-- Campo para a hora final da classe -->
            <label for="finalHour" class="form-label"><strong>Hora Final:</strong></label>
            <input type="time" id="finalHour" name="finalHour" class="form-control" required>
        </div>

        <div class="form-group row"> <!-- Botões para submeter ou cancelar -->
            <div class="col">
                <button type="submit" class="mb-3 btn btn-success float-left">Criar</button> <!-- Botão de criação -->
            </div>
            <div class="col">
                <a href="./index.php?page=classes" class="btn btn-light float-right">Cancelar</a> <!-- Link para cancelar -->
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