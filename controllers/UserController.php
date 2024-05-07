<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/generateRandomPassword.php';

// Instância da classe User
$user = new User($conn);

// Verifica o método HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação e Sanitização dos Dados
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;

    // Verifica a ação a ser executada
    $action = isset($_GET['action']) ? strtolower($_GET['action']) : '';

    // Função para criar o array de dados do usuário, com tipo padrão como 'student'
    function getUserData($post)
    {
        $password = generateRandomPassword(); // Gera uma senha aleatória

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
            "postalCode" => htmlspecialchars($post["postalCode"] ?? ''),
            "maritalStatus" => htmlspecialchars($post["maritalStatus"] ?? ''),
            "gender" => htmlspecialchars($post["gender"] ?? ''),
            "birthDate" => htmlspecialchars($post["birthDate"] ?? ''),
            "password" => $password,
            "type" => 'student', // Define o tipo padrão como 'student'
        ];
    }

    // Executa ações conforme o parâmetro 'action'
    switch ($action) {
        case 'create': // Cria um novo usuário
            $data = getUserData($_POST);
            if ($user->create($data)) {
                header("Location: ../index.php?page=users&action=success");
            } else {
                header("Location: ../index.php?page=users&action=fail");
            }
            break;

        case 'update': // Atualiza um usuário existente
            if ($id === null) {
                header("Location: ../index.php?page=users&action=invalid");
                exit;
            }
            $data = getUserData($_POST);
            if ($user->update($data, $id)) {
                header("Location: ../index.php?page=users&action=saved");
            } else {
                header("Location: ../index.php?page=users&action=fail");
            }
            break;

        case 'delete': // Deleta um usuário pelo ID
            if ($id === null) {
                header("Location: ../index.php?page=users&action=invalid");
                exit;
            }
            if ($user->delete($id)) {
                header("Location: ../index.php?page=users&action=deleted");
            } else {
                header("Location: ../index.php?page=users&action=fail");
            }
            break;

        default: // Se nenhuma ação for definida
            header("Location: ../index.php?page=users&action=unknown");
            break;
    }
}
