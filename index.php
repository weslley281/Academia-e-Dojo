<?php
session_start();
if (!isset($_SESSION["user_id"]) && !isset($_GET['page'])) {
    echo "<script language='javascript'>window.location='./index.php?page=login'; </script>";
}
require_once "./config/db.php";
require_once "./config/CreateTables.php";
require_once "./utils/renderAlert.php";
require_once "./utils/truncate.php";
require_once './models/User.php';
require_once './models/MartialArt.php';
require_once './models/Class.php';
$createTable = new CreateTables;
$user = new User($conn);
$martialart = new MartialArt($conn);
$class = new ClassModel($conn);

$createTable->createUsersTable($conn);
$createTable->createMartialArtsTable($conn);
$createTable->createClassTable($conn);

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? '';

if (!$user->getByEmail("instituto@kenshydokan.org.br")) {
    $password = password_hash("admin@123", PASSWORD_DEFAULT);
    $data = [
        "name" => 'Kenshydokan',
        "phone" => '65981233996',
        "email" => "instituto@kenshydokan.org.br",
        "address" => "Rua Tal tal tal",
        "complement" => "Perto de tal",
        "country" => "Brasil",
        "state" => "Mato Grosso",
        "city" => "Várzea Grande",
        "neighborhood" => "Centro",
        "postalCode" => "78000-000",
        "maritalStatus" => "single",
        "gender" => "mmasculine",
        "birthDate" => "2000-01-01",
        "password" => $password,
        "type" => 'admin',
        "cpf" => '10.707.722/0001-34',
    ];

    $user->create($data);
}

include_once './views/navbar.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./libs/bootstrap/bootstrap.css">
    <link href="./libs/fontawesome-free-6.5.2-web/css/fontawesome.css" rel="stylesheet" />
    <link href="./libs/fontawesome-free-6.5.2-web/css/brands.css" rel="stylesheet" />
    <link href="./libs/fontawesome-free-6.5.2-web/css/solid.css" rel="stylesheet" />

    <script src="./libs/bootstrap/jquery.js"></script>
    <script src="./libs/bootstrap/popper.js"></script>
    <script src="./libs/bootstrap/bootstrap.js"></script>
</head>

<body>
    <div class="container">
        <?php
        // Usando switch para simplificar condicionais
        switch ($page) {
            case 'dashboard':
                include_once "./views/dashboard.php";
                break;

            case 'login':
                switch ($action) {
                    case 'success':
                        echo renderAlert('success', 'Sucesso!', 'Loguin Registrado com Sucesso. Você já pode navegar.');
                        echo "<script>";
                        echo "setTimeout(function() { window.location.href = './index.php?page=dashboard'; }, 5000);";
                        echo "</script>";

                        break;

                    case 'fail':
                        echo renderAlert('danger', 'Erro!', 'Erro ao fazer login: usuário ou senha incorreto.');
                        include_once './views/login.php';
                        break;
                    default:
                        include_once './views/login.php';
                        break;
                }
                break;
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
                            echo renderAlert('success', 'Sucesso!', 'Arte Marcial criada com sucesso.');
                            break;

                        case 'fail':
                            echo renderAlert('danger', 'Erro!', 'Erro ao criar o Arte Marcial.');
                            break;

                        case 'saved':
                            echo renderAlert('info', 'Sucesso!', 'Arte Marcial editada com sucesso.');
                            break;

                        case 'deleted':
                            echo renderAlert('warning', 'Sucesso!', 'Arte Marcial deletada.');
                            break;
                    }
                }

                include_once './views/martialArt/index.php';

                break;

            case 'classes':

                if ($action === 'create') {
                    include_once './views/class/create.php';
                } else {
                    switch ($action) {
                        case 'success':
                            echo renderAlert('success', 'Sucesso!', 'Turma criada com sucesso.');
                            break;

                        case 'fail':
                            echo renderAlert('danger', 'Erro!', 'Erro ao criar o turma.');
                            break;

                        case 'saved':
                            echo renderAlert('info', 'Sucesso!', 'Turma editada com sucesso.');
                            break;

                        case 'deleted':
                            echo renderAlert('warning', 'Sucesso!', 'Turma deletada.');
                            break;
                    }
                }

                include_once './views/class/index.php';

                break;

            default:
                echo "<h2>Página não encontrada</h2>";
                break;
        }
        ?>
    </div>
</body>

</html>