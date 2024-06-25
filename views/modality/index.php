<div class="container mt-5">
    <h1>Lista de Modalities</h1>
    <a href="index.php?page=modalities&action=create" class="btn btn-success mb-3">Criar nova Classe</a> <!-- Botão para criar nova classe -->
    <table id="minhaTabela" class="table table-striped"> <!-- Tabela para exibir as modalities -->
        <thead>
            <tr>
                <th>Nome</th>
                <th>Professor</th>
                <th>Valor</th>
                <th>Hora Inicial</th>
                <th>Hora Final</th>
                <th>Duração</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $modalities = $class->getAll(); // Obtém todas as modalities do modelo

            if (isset($modalities) && !empty($modalities)) { // Verifica se há modalities para exibir
                foreach ($modalities as $class_item) {

                    $get_user = $user->getById($class_item['id_instructor']);
                    $valorFormatado = number_format((float) $class_item['value'], 2, ',', '.');
            ?>
                    <tr>
                        <td><?= htmlspecialchars($class_item['name']) ?></td> <!-- Nome da classe -->
                        <td><?= htmlspecialchars($get_user["name"]) ?></td> <!-- Descrição truncada -->
                        <td>R$ <?= htmlspecialchars($valorFormatado) ?></td> <!-- Hora inicial -->
                        <td><?= htmlspecialchars($class_item['initial_hour']) ?></td> <!-- Hora inicial -->
                        <td><?= htmlspecialchars($class_item['final_hour']) ?></td> <!-- Hora final -->
                        <td><?= htmlspecialchars($class_item['days']) . " dias" ?></td> <!-- Hora final -->
                        <td> <!-- Ações para edição e exclusão -->
                            <a href="index.php?page=modalities&action=update&id=<?= $class_item['id'] ?>" class="btn btn-info"><i class="fa-regular fa-pen-to-square"></i></a>
                            <a href="index.php?page=modalities&action=delete&id=<?= $class_item['id'] ?>" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></a>
                        </td>
                        <?php
                        // Incluir a view de atualização se a ação for 'update' e o ID for correspondente
                        if (isset($_GET["action"]) && $_GET["action"] == "update" && isset($_GET["id"]) && $_GET["id"] == $class_item['id']) {
                            include_once "update.php";
                        }
                        // Incluir a view de exclusão se a ação for 'delete' e o ID for correspondente
                        elseif (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"]) && $_GET["id"] == $class_item['id']) {
                            include_once "delete.php";
                        }
                        ?>
                    </tr>
            <?php
                } // Fim do loop para listar as modalities
            }
            ?>
        </tbody>
    </table>
</div>