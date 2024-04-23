<?php
require_once "./config/db.php";
require_once "./config/CreateTables.php";
require_once './models/User.php';
$createTable = new CreateTables;
$createTable->createUsersTable($conn);


// Cria a instância do modelo User para obter dados dos usuários
$userModel = new User($conn);
$users = $userModel->getAll();

// Contagem total de usuários
$totalUsers = count($users);

include_once './views/navbar.php'; // Inclui a barra de navegação
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./libs/bootstrap/bootstrap.css">

    <script src="./libs/bootstrap/jquery.js"></script>
    <script src="./libs/bootstrap/popper.js"></script>
    <script src="./libs/bootstrap/bootstrap.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h1>User Dashboard</h1>

        <!-- Estatísticas -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Statistics</h5>
                <p>Total Users: <?= $totalUsers ?></p>
            </div>
        </div>

        <!-- Tabela de Usuários -->
        <h2>User List</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <a href="update.php?id=<?= $user['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="index.php?action=delete&id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>

</html>