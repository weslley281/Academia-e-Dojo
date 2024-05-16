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
$createTable->createClassDaysTable($conn);

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? '';

$titles = [
    'dashboard' => 'Painel de Controle',
    'login' => 'Login',
    'users' => 'Usuários',
    'martial_arts' => 'Artes Marciais',
    'classes' => 'Turmas',
    'financial' => 'Financeiro'
];

$page_title = isset($titles[$page]) ? $titles[$page] : 'Página não encontrada';

if (!$user->getByEmail("instituto@kenshydokan.org.br")) {
    $password = password_hash("admin@123", PASSWORD_DEFAULT);

    $data = [
        "name" => 'Kenshydokan',
        "phone" => '65981233996',
        "email" => "instituto@kenshydokan.org.br",
        "address" => "R. 24 de Outubro, 185",
        "complement" => "Edifício",
        "country" => "Brasil",
        "state" => "Mato Grosso",
        "city" => "Várzea Grande",
        "neighborhood" => "Centro Norte",
        "postalCode" => "78110-520",
        "maritalStatus" => "single",
        "gender" => "mmasculine",
        "birthDate" => "2000-01-01",
        "password" => $password,
        "type" => 'admin',
        "cpf" => '10.707.722/0001-34',
    ];

    $user->create($data);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Weslley Henrique Vieira Ferraz" />
    <meta name="owner" content="Federação de Karate de Contato do Estado de Mato Grosso" />
    <meta name="copyright" content="Weslley Henrique Vieira Ferraz" />
    <meta name="keywords" content="sistema, web, desktop, mobile, gerenciamento, kenshydokan, kyokushin, federação, karate, carate, karatê, caratê, de contato, full, contact, luta, aula, aulas, Karatê, kata, kumite, mato grosso, cuiaba, varzea grande, weslley ferraz, weslley, ferraz, judo, judô, kodokan, jiu, jiu jitsu, muay thai, muay boran, kickboxing">
    <meta name="description" content="Somos uma federação, criada com o intuito de divulgar o karate kenshydokan e outras artes marciais.">
    <meta http-equiv="refresh" content="3600">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo $page_title; ?></title>

    <link rel="stylesheet" href="./libs/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link href="./libs/fontawesome-free-6.5.2-web/css/fontawesome.css" rel="stylesheet" />
    <link href="./libs/fontawesome-free-6.5.2-web/css/brands.css" rel="stylesheet" />
    <link href="./libs/fontawesome-free-6.5.2-web/css/solid.css" rel="stylesheet" />
    <link rel="stylesheet" href="./libs/DataTables/datatables.css">
    <link rel="icon" href="./images/logo-kenshydokan.png" type="image/jpg">
</head>

<body>
    <?php include_once './views/navbar.php'; ?>
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
                        echo "setTimeout(function() { window.location.href = './index.php?page=dashboard'; }, 3000);";
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

            case 'martial_arts':

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

            case "financial":
                include_once './views/financial/index.php';
                break;

            default:
                echo "<h2>Página não encontrada</h2>";
                break;
        }
        ?>
    </div>

    <script src="./libs/bootstrap/jquery.js"></script>
    <script src="./libs/bootstrap/popper.js"></script>
    <script src="./libs/bootstrap/bootstrap.js"></script>
    <script src="./utils/maskCPF.js"></script>
    <script src="./libs/DataTables/datatables.js"></script>
    <script src="./libs/tinymce/tinymce.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#minhaTabela').DataTable({
                "order": [
                    [0, "asc"]
                ], // Ordena a primeira coluna em ordem crescente
                "pageLength": 10, // Define o número de registros por página
                "searching": true // Habilita a pesquisa
            });
        });
    </script>

    <script>
        function formatarNumero(input) {
            if (input.id === "value") {
                // Remove caracteres que não são números, pontos ou a primeira ocorrência de ponto após a primeira posição
                input.value = input.value.replace(/[^\d.]/g, '').replace(/^(\d*\.)(.*)\./g, '$1$2');
            }
        }
    </script>


    <script>
        tinymce.init({
            selector: 'textarea#description',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            language: 'pt_BR',
        });
    </script>
</body>

</html>