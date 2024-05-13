<div class="container mt-5">
    <h1>Users List</h1>
    <a href="index.php?page=users&action=create" class="btn btn-success mb-3">Criar novo Usuário</a>
    <table class="table table-striped">
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
                            <a href="index.php?page=users&action=update&id=<?= $user['id'] ?>" class="btn btn-info">Editar</a>
                            <a href="index.php?page=users&action=delete&id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                            <?php
                            if (isset($_SESSION["type"]) && $_SESSION["type"] == "admin") {
                            ?>
                                <form action="./controllers/UserController.php" method="POST">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                                    <select name="type" class="form-control" id="type">
                                        <option value="<?= htmlspecialchars($user['type']) ?>"><?= htmlspecialchars($user['type']) ?></option>
                                    </select>
                                </form>
                            <?php
                            }
                            ?>
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