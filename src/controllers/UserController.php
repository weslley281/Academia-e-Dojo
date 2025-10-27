<?php
session_start();
if (isset($_SESSION["user_id"]) && isset($_SESSION['type']) && in_array($_SESSION['type'], ['admin', 'instructor'])) {
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../utils/generateRandomPassword.php';
    require_once __DIR__ . '/../utils/openssl.php';

    $user = new User($conn);

    // Verifica o método HTTP
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validação e Sanitização dos Dados
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;

        // Verifica a ação a ser executada
        $action = isset($_GET['action']) ? strtolower($_GET['action']) : '';

        define('ENCRYPTION_KEY', 'gotosao');

        // Função para criar o array de dados do usuário, com tipo padrão como 'student'
        function getUserData($post)
        {
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            return [
                "name" => htmlspecialchars($post["name"] ?? ''),
                "phone" => htmlspecialchars($post["phone"] ?? ''),
                "email" => filter_var($post["email"], FILTER_VALIDATE_EMAIL),
                "address" => htmlspecialchars($post["address"] ?? ''),
                "complement" => htmlspecialchars($post["complement"] ?? ''),
                "country" => htmlspecialchars($post["country"] ?? ''),
                "state" => htmlspecialchars($post["state"] ?? ''),
                "city" => htmlspecialchars($post["city"] ?? ''),
                "neighborhood" => htmlspecialchars($post["neighborhood"] ?? ''),
                "postal_code" => htmlspecialchars($post["postal_code"] ?? ''),
                "marital_status" => htmlspecialchars($post["marital_status"] ?? ''),
                "gender" => htmlspecialchars($post["gender"] ?? ''),
                "birth_date" => htmlspecialchars($post["birth_date"] ?? ''),
                "status" => 1,
                "password" => $password,
                "type" => htmlspecialchars($post["type"] ?? 'student'), // Usa o tipo do formulário ou 'student' como padrão
            ];
        }

        // Executa ações conforme o parâmetro 'action'
        switch ($action) {
            case 'create': // Cria um novo usuário

                if ($_POST["password"] == $_POST["password2"]) {

                    $data = getUserData($_POST);

                    if ($user->create($data)) {
                        header("Location: ../index.php?page=users&action=success");
                    } else {
                        echo $user->create($data);
                        header("Location: ../index.php?page=users&action=fail");
                    }
                } else {
                    echo "<center><strong><h1>As duas senhas diferem uma da outra</h1></strong></center>";
                    echo "<script>";
                    echo "setTimeout(function() { window.location.href = '../index.php?page=users&action=fail'; }, 3000);";
                    echo "</script>";
                }
                break;

            case 'update': // Atualiza um usuário existente
                if ($id === null) {
                    header("Location: ../index.php?page=users&action=invalid");
                    exit;
                }

                // Busca os dados atuais do usuário para preservar a senha e o tipo
                $currentUser = $user->getById($id);
                if (!$currentUser) {
                    header("Location: ../index.php?page=users&action=fail");
                    exit;
                }

                // Monta o array de dados com as informações do formulário
                $data = [
                    "name" => htmlspecialchars($_POST["name"] ?? ''),
                    "phone" => htmlspecialchars($_POST["phone"] ?? ''),
                    "email" => filter_var($_POST["email"], FILTER_VALIDATE_EMAIL),
                    "address" => htmlspecialchars($_POST["address"] ?? ''),
                    "complement" => htmlspecialchars($_POST["complement"] ?? ''),
                    "country" => htmlspecialchars($_POST["country"] ?? ''),
                    "state" => htmlspecialchars($_POST["state"] ?? ''),
                    "city" => htmlspecialchars($_POST["city"] ?? ''),
                    "neighborhood" => htmlspecialchars($_POST["neighborhood"] ?? ''),
                    "postal_code" => htmlspecialchars($_POST["postal_code"] ?? ''),
                    "marital_status" => htmlspecialchars($_POST["marital_status"] ?? ''),
                    "gender" => htmlspecialchars($_POST["gender"] ?? ''),
                    "birth_date" => htmlspecialchars($_POST["birth_date"] ?? ''),
                    "status" => 1, // Mantém o status como ativo
                    "password" => $currentUser['password'], // REUTILIZA A SENHA ATUAL
                    "type" => $currentUser['type'], // REUTILIZA O TIPO ATUAL
                ];

                if ($user->update($data, id: $id)) {
                    header("Location: ../index.php?page=users&action=saved");
                } else {
                    header("Location: ../index.php?page=users&action=fail");
                }
                break;

            case 'updatetype':
                if ($id === null) {
                    header("Location: ../index.php?page=users&action=invalid");
                    exit;
                }

                if ($user->updateType($_POST["type"], $id)) {
                    header("Location: ../index.php?page=users&action=saved");
                } else {
                    header("Location: ../index.php?page=users&action=fail");
                }
                break;

            case 'delete': // Deleta um usuário pelo ID
                echo "executou aqui";
                if ($_SESSION['type'] !== 'admin') {
                    header("Location: ../index.php?page=users&action=permission_error");
                    echo "<center><strong><h1>Você não Tem permição para isso</h1></strong></center>";
                    exit;
                }
                if ($id === null) {
                    header("Location: ../index.php?page=users&action=invalid");
                    echo "id nulo";
                    exit;
                }

                if ($user->delete($id)) {
                    header("Location: ../index.php?page=users&action=deleted");
                    echo "deletado com sucesso";
                } else {
                    header("Location: ../index.php?page=users&action=fail");
                    echo "falha ao salvar no banco";
                }
                break;

            default: // Se nenhuma ação for definida
                echo "<center><strong><h1>Ação incorreta</h1></strong></center>";
                header("Location: ../index.php?page=users&action=unknown");
                echo $_GET['action'];
                break;
        }
    }
} else {
    echo "<center><strong><h1>Você não Tem permição para isso</h1></strong></center>";
    echo "<script>";
    echo "setTimeout(function() { window.location.href = '../index.php?page=login'; }, 3000);";
    echo "</script>";
}
