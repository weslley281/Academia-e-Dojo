<div class="container mt-5">
    <h1>Lista de Classes</h1>
    <a href="index.php?page=classes&action=create" class="btn btn-success mb-3">Criar nova Classe</a> <!-- Botão para criar nova classe -->
    <table id="minhaTabela" class="table table-striped"> <!-- Tabela para exibir as classes -->
        <thead>
            <tr>
                <th>Nome</th>
                <th>Professor</th>
                <th>Hora Inicial</th>
                <th>Hora Final</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $classes = $class->getAll(); // Obtém todas as classes do modelo

            if (isset($classes) && !empty($classes)) { // Verifica se há classes para exibir
                foreach ($classes as $class) {
                    //echo $class['idInstructor'];
                    $get_user = $user->getById($class['idInstructor']);
                    //print_r($get_user);
            ?>
                    <tr>
                        <td><?= htmlspecialchars($class['name']) ?></td> <!-- Nome da classe -->
                        <td><?= htmlspecialchars($get_user["name"]) ?></td> <!-- Descrição truncada -->
                        <td><?= htmlspecialchars($class['initialHour']) ?></td> <!-- Hora inicial -->
                        <td><?= htmlspecialchars($class['finalHour']) ?></td> <!-- Hora final -->
                        <td> <!-- Ações para edição e exclusão -->
                            <a href="index.php?page=classes&action=update&id=<?= $class['id'] ?>" class="btn btn-info"><i class="fa-regular fa-pen-to-square"></i></a>
                            <a href="index.php?page=classes&action=delete&id=<?= $class['id'] ?>" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></a>
                        </td>
                        <?php
                        // Incluir a view de atualização se a ação for 'update' e o ID for correspondente
                        if (isset($_GET["action"]) && $_GET["action"] == "update" && isset($_GET["id"]) && $_GET["id"] == $class['id']) {
                            include_once "update.php";
                        }
                        // Incluir a view de exclusão se a ação for 'delete' e o ID for correspondente
                        elseif (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"]) && $_GET["id"] == $class['id']) {
                            include_once "delete.php";
                        }
                        ?>
                    </tr>
            <?php
                } // Fim do loop para listar as classes
            }
            ?>
        </tbody>
    </table>
</div>