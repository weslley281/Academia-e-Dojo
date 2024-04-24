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
$users = $userController->read();

if (isset($users) && !empty($users)) {
    echo "entrei aqui";
    foreach ($users as $user) {?>
                <tr>
                    <td><?=htmlspecialchars($user['name'])?></td>
                    <td><?=htmlspecialchars($user['email'])?></td>
                    <td>
                        <a href="update.php?id=<?=$user['id']?>" class="btn btn-warning">Editar</a>
                        <a href="../../index.php?action=delete&id=<?=$user['id']?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php }
}
?>
        </tbody>
    </table>
</div>