<div class="container mt-5">
    <h1>Criar Classe</h1> <!-- Título da página -->
    <form action="./controllers/ClassController.php?action=create" method="post" class="form-group"> <!-- Ação do formulário -->
        <div class="mb-3 form-group"> <!-- Campo para o nome da classe -->
            <label for="name" class="form-label"><strong>Nome:</strong></label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3"> <!-- Campo para a descrição da classe -->
            <label for="description" class="form-label"><strong>Descrição:</strong></label>
            <textarea name="description" id="description" class="form-control" cols="30" rows="5" required></textarea>
        </div>

        <div class="mb-3"> <!-- Campo para o ID da arte marcial associada -->
            <label for="idMartialArt" class="form-label"><strong>Arte Marcial:</strong></label>
            <input type="number" id="idMartialArt" name="idMartialArt" class="form-control" required>
        </div>

        <div class="mb-3"> <!-- Campo para o ID do instrutor associado -->
            <label for="idInstructor" class="form-label"><strong>Instrutor:</strong></label>
            <input type="number" id="idInstructor" name="idInstructor" class="form-control" required>
        </div>

        <div class="mb-3"> <!-- Campo para a hora inicial da classe -->
            <label for="initialHour" class="form-label"><strong>Hora Inicial:</strong></label>
            <input type="time" id="initialHour" name="initialHour" class="form-control" required>
        </div>

        <div class="mb-3"> <!-- Campo para a hora final da classe -->
            <label for="finalHour" class="form-label"><strong>Hora Final:</strong></label>
            <input type="time" id="finalHour" name="finalHour" class="form-control" required>
        </div>

        <div class="row"> <!-- Botões para submeter ou cancelar -->
            <div class="col">
                <button type="submit" class="mb-3 btn btn-success float-left">Criar</button> <!-- Botão de criação -->
            </div>
            <div class="col">
                <a href="./index.php?page=classes" class="btn btn-light float-right">Cancelar</a> <!-- Link para cancelar -->
            </div>
        </div>
    </form>
</div>
