<?php
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION['type'] == "admin") {
    require_once __DIR__ . '/../models/Class.php';
    require_once __DIR__ . '/../config/db.php';

    // Instância do modelo ClassModel
    $classModel = new ClassModel($conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        $action = isset($_GET['action']) ? strtolower($_GET['action']) : '';

        function getClassData($post)
        {
            return [
                "id_martial_art" => intval($post["id_martial_art"] ?? 0),
                "id_instructor" => intval($post["id_instructor"] ?? 0),
                "name" => htmlspecialchars($post["name"] ?? ''),
                "description" => htmlspecialchars($post["description"] ?? ''),
                "value" => htmlspecialchars($post["value"] ?? ''),
                "initialHour" => htmlspecialchars($post["initialHour"] ?? ''),
                "finalHour" => htmlspecialchars($post["finalHour"] ?? ''),
                "days" => htmlspecialchars($post["days"] ?? 0),
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
} else {
    echo "<center><strong><h1>Você não Tem permição para isso</h1></strong></center>";
    echo "<script>";
    echo "setTimeout(function() { window.location.href = '../index.php?page=login'; }, 3000);";
    echo "</script>";
}
