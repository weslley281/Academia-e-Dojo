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

include_once './views/navbar.php';
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

    <div class="container">
        <?php
        if (isset($_GET["page"]) && $_GET["page"] == "user") {
            if (isset($_GET["action"]) && $_GET["action"] == "create") {
                include_once('./views/user/create.php');
            }

            include_once('./views/user/index.php');
        }
        ?>
    </div>

</body>

</html>