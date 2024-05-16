<div class="container mt-5">
    <h1>Lista de Artes Marciais</h1>
    <a href="index.php?page=martial_arts&action=create" class="btn btn-success mb-3">Criar nova Arte Marcial</a>
    <table id="minhaTabela" class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $martialarts = $martialart->getAll();

            if (isset($martialarts) && !empty($martialarts)) {
                foreach ($martialarts as $martialart) {
                    $description = truncate($martialart['description'], 50);
            ?>
                    <tr>
                        <td><?= htmlspecialchars($martialart['name']) ?></td>
                        <td><?= htmlspecialchars($description) ?></td>
                        <td>
                            <a href="index.php?page=martial_arts&action=update&id=<?= $martialart['id'] ?>" class="btn btn-info"><i class="fa-regular fa-pen-to-square"></i></a>
                            <a href="index.php?page=martial_arts&action=delete&id=<?= $martialart['id'] ?>" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></a>
                        </td>
                        <?php
                        if (isset($_GET["action"]) && $_GET["action"] == "update" && isset($_GET["id"]) && $_GET["id"] == $martialart['id']) {
                            include_once "update.php";
                        } elseif (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"]) && $_GET["id"] == $martialart['id']) {
                            include_once "delete.php";
                        }
                        ?>
                    </tr>
            <?php }
            }
            ?>
        </tbody>
    </table>
</div>