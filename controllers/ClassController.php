<?php
require_once __DIR__ . '/../models/ClassModel.php';
require_once __DIR__ . '/../config/db.php';

// Instância do modelo ClassModel
$classModel = new ClassModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $action = isset($_GET['action']) ? strtolower($_GET['action']) : '';

    function getClassData($post)
    {
        return [
            "idMartialArt" => intval($post["idMartialArt"] ?? 0),
            "idInstructor" => intval($post["idInstructor"] ?? 0),
            "name" => htmlspecialchars($post["name"] ?? ''),
            "description" => htmlspecialchars($post["description"] ?? ''),
            "initialHour" => htmlspecialchars($post["initialHour"] ?? ''),
            "finalHour" => htmlspecialchars($post["finalHour"] ?? ''),
        ];
    }

    switch ($action) {
        case 'create':
            $data = getClassData($_POST);
            if ($classModel->create($data)) {
                header("Location: ../index.php?page=classes&action=success");
            } else {
                header("Location: ../index.php?page=classes&action=fail");
            }
            break;

        case 'update':
            if ($id === null) {
                header("Location: ../index.php?page=classes&action=invalid");
                exit;
            }
            $data = getClassData($_POST);
            if ($classModel->update($data, $id)) {
                header("Location: ../index.php?page=classes&action=saved");
            } else {
                header("Location: ../index.php?page=classes&action=fail");
            }
            break;

        case 'delete':
            if ($id === null) {
                header("Location: ../index.php?page=classes&action=invalid");
                exit;
            }
            if ($classModel->delete($id)) {
                header("Location: ../index.php?page=classes&action=deleted");
            } else {
                header("Location: ../index.php?page=classes&action=fail");
            }
            break;

        default:
            header("Location: ../index.php?page=classes&action=unknown");
            break;
    }
}
