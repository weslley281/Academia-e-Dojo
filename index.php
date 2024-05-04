<?php
require_once "./config/db.php";
require_once "./utils/renderAlert.php";
require_once "./config/CreateTables.php";
require_once './models/User.php';
require_once './models/MartialArt.php';
$createTable = new CreateTables;
$user = new User($conn);
$martialart = new MartialArt($conn);

$createTable->createUsersTable($conn);
$createTable->createMartialArtsTable($conn);

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? '';

include_once './views/navbar.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

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
        // Usando switch para simplificar condicionais
        switch ($page) {
            case 'users':

                if ($action === 'create') {
                    include_once './views/user/create.php';
                } else {
                    switch ($action) {
                        case 'success':
                            echo renderAlert('success', 'Sucesso!', 'Usuário criado com sucesso.');
                            break;

                        case 'fail':
                            echo renderAlert('danger', 'Erro!', 'Erro ao criar o usuário.');
                            break;

                        case 'saved':
                            echo renderAlert('info', 'Sucesso!', 'Usuário editado com sucesso.');
                            break;

                        case 'deleted':
                            echo renderAlert('warning', 'Sucesso!', 'Usuário deletado.');
                            break;
                    }
                }

                include_once './views/user/index.php';

                break;

            case 'martialArts':

                if ($action === 'create') {
                    include_once './views/martialArt/create.php';
                } else {
                    switch ($action) {
                        case 'success':
                            echo renderAlert('success', 'Sucesso!', 'Usuário criado com sucesso.');
                            break;

                        case 'fail':
                            echo renderAlert('danger', 'Erro!', 'Erro ao criar o usuário.');
                            break;

                        case 'saved':
                            echo renderAlert('info', 'Sucesso!', 'Usuário editado com sucesso.');
                            break;

                        case 'deleted':
                            echo renderAlert('warning', 'Sucesso!', 'Usuário deletado.');
                            break;
                    }
                }

                include_once './views/martialArt/index.php';

                break;

            default:
                echo "<h2>Página não encontrada</h2>";
                break;
        }
        ?>
    </div>
</body>

</html>