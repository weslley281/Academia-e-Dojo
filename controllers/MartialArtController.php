<?php
require_once __DIR__ . '/../models/MartialArt.php';
require_once __DIR__ . '/../config/db.php';

// Instância da classe MartialArt
$martialArt = new MartialArt($conn);

// Verifica o método HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação e Sanitização dos Dados
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;

    // Verifica a ação a ser executada
    $action = isset($_GET['action']) ? strtolower($_GET['action']) : '';

    // Função para criar o array de dados de usuário
    function getMartialArtData($post)
    {
        return [
            "name" => htmlspecialchars($post["name"] ?? ''),
            "description" => htmlspecialchars($post["description"] ?? ''),
        ];
    }

    switch ($action) {
        case 'create':
            $data = getMartialArtData($_POST);
            if ($martialArt->create($data)) {
                header("Location: ../index.php?page=martialArts&action=success");
            } else {
                header("Location: ../index.php?page=martialArts&action=fail");
            }
            break;

        case 'update':
            if ($id === null) {
                header("Location: ../index.php?page=martialArts&action=invalid");
                exit;
            }
            $data = getMartialArtData($_POST);
            if ($martialart->update($data, $id)) {
                header("Location: ../index.php?page=martialArts&action=saved");
            } else {
                header("Location: ../index.php?page=martialArts&action=fail");
            }
            break;

        case 'delete':
            if ($id === null) {
                header("Location: ../index.php?page=martialArts&action=invalid");
                exit;
            }
            if ($martialart->delete($id)) {
                header("Location: ../index.php?page=martialArts&action=deleted");
            } else {
                header("Location: ../index.php?page=martialArts&action=fail");
            }
            break;

        default:
            header("Location: ../index.php?page=martialArts&action=unknown");
            break;
    }
}