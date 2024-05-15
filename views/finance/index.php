<div class="container mt-5">
    <h1>Vendas</h1>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 my-2">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="./images/venda.jpg" alt="Imagem de capa do card">
                    <div class="card-body">
                        <h5 class="card-title">Vender Plano</h5>
                        <p class="card-text">Venda combo de planos</strong>.</p>
                        <a href="index.php?page=finance&action=sell" class="btn btn-primary"><i class="fa-solid fa-eye"></i> Visitar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="index.php?page=martialArts&action=create" class="btn btn-success mb-3">Criar nova Arte Marcial</a>
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
                            <a href="index.php?page=martialArts&action=update&id=<?= $martialart['id'] ?>" class="btn btn-info"><i class="fa-regular fa-pen-to-square"></i></a>
                            <a href="index.php?page=martialArts&action=delete&id=<?= $martialart['id'] ?>" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></a>
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