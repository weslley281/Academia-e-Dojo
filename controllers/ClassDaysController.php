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

        switch ($action) {
            case 'create':
                if ($classModel->createClassDays($id, $_POST["day_of_week"])) {
                    header("Location: ../index.php?page=classes&action=success");
                } else {
                    header("Location: ../index.php?page=classes&action=fail");
                }
                break;

            case 'delete':
                if ($id === null) {
                    header("Location: ../index.php?page=classes&action=invalid");
                    exit;
                }
                if ($classModel->deleteClassDays($id)) {
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
