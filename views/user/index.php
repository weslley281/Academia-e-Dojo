<div class="container mt-5">
    <h1>Lista de Usuário</h1>
    <a href="index.php?page=users&action=create" class="btn btn-success mb-3">Criar novo Usuário</a>
    <table id="minhaTabela" class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = $user->getAll();

            if (isset($users) && !empty($users)) {
                foreach ($users as $user) { ?>
                    <tr>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href="index.php?page=users&action=update&id=<?= $user['id'] ?>" class="btn btn-info">Editar</a>
                                </div>
                                <div class="col-sm-3">
                                    <a href="index.php?page=users&action=delete&id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    if (isset($_SESSION["type"]) && $_SESSION["type"] == "admin") {
                                    ?>
                                        <form action="./controllers/UserController.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                                                    <select name="type" class="form-control" id="type">
                                                        <option value="<?= htmlspecialchars($user['type']) ?>">Estudante</option>
                                                        <option value="instructor">Instrutor</option>
                                                    </select>

                                                </div>
                                                <div class="col-sm-3">
                                                    <button class="btn btn-secondary" type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <?php
                        if (isset($_GET["action"]) && $_GET["action"] == "update" && isset($_GET["id"]) && $_GET["id"] == $user['id']) {
                            include_once "update.php";
                        } elseif (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"]) && $_GET["id"] == $user['id']) {
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