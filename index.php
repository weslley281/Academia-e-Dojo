<?php
require_once "./config/db.php";
require_once "./config/CreateTables.php";
require_once './models/User.php';
$createTable = new CreateTables;
$user = new User($conn);
$createTable->createUsersTable($conn);
$createTable->createMartialArtsTable($conn);

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
if (isset($_GET["page"]) && $_GET["page"] == "users") {
    if (isset($_GET["action"]) && $_GET["action"] == "create") {
        include_once './views/user/create.php';
    }

    if (isset($_GET["action"]) && $_GET["action"] == "success") {
        ?>
                <div class="mt-5 alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sucesso!</strong> Usuário criado!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
} elseif (isset($_GET["action"]) && $_GET["action"] == "fail") {
        ?>
                <div class="mt-5 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erro!</strong> Erro ao criar o usuário!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
} elseif (isset($_GET["action"]) && $_GET["action"] == "saved") {
        ?>
                <div class="mt-5 alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Sucesso!</strong> Usuário editado!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
} elseif (isset($_GET["action"]) && $_GET["action"] == "deleted") {
        ?>
                <div class="mt-5 alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Sucesso!</strong> Usuário deletado!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        <?php
}

    include_once './views/user/index.php';
}
?>
    </div>

</body>

</html>