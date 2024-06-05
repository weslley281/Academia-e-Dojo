<?php
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION['type'] == "admin") {
    require_once __DIR__ . '/../models/SalesRecords.php';
    require_once __DIR__ . '/../config/db.php';

    // Instância da classe SalesRecord
    $salesRecord = new SalesRecord($conn);

    // Verifica o método HTTP
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validação e Sanitização dos Dados
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;

        // Verifica a ação a ser executada
        $action = isset($_GET['action']) ? strtolower($_GET['action']) : '';

        // Função para criar o array de dados de usuário
        function getSalesRecordData($post)
        {
            return [
                "name" => htmlspecialchars($post["name"] ?? ''),
                "description" => htmlspecialchars($post["description"] ?? ''),
            ];
        }

        switch ($action) {
            case 'create':
                $data = getSalesRecordData($_POST);
                if ($salesRecord->create($data)) {
                    header("Location: ../index.php?page=financial&action=sell");
                } else {
                    header("Location: ../index.php?page=financial&action=sell");
                }
                break;

            case 'update':
                if ($id === null) {
                    header("Location: ../index.php?page=financial&action=sell");
                    exit;
                }
                $data = getSalesRecordData($_POST);
                if ($salesRecord->update($data, $id)) {
                    header("Location: ../index.php?page=financial&action=sell");
                } else {
                    header("Location: ../index.php?page=financial&action=sell");
                }
                break;
            
            case 'update_client':
                if ($id === null) {
                    header("Location: ../index.php?page=financial&action=sell");
                    exit;
                }

                if ($salesRecord->updateClient($_POST["client"], $id)) {
                    header("Location: ../index.php?page=financial&action=sell");
                } else {
                    header("Location: ../index.php?page=financial&action=sell");
                }
                break;

            case 'delete':
                if ($id === null) {
                    header("Location: ../index.php?page=financial&action=sell");
                    exit;
                }
                if ($salesRecord->delete($id)) {
                    header("Location: ../index.php?page=financial&action=sell");
                } else {
                    header("Location: ../index.php?page=financial&action=sell");
                }
                break;

            case 'discount':
                if ($id === null) {
                    header("Location: ../index.php?page=financial&action=sell");
                    exit;
                }

                if ($salesRecord->updateDiscount($_POST["discount"], $id)) {
                    header("Location: ../index.php?page=financial&action=sell");
                } else {
                    header("Location: ../index.php?page=financial&action=sell");
                }
                break;
                
            default:
                //header("Location: ../index.php?page=financial&action=sell");
                break;
        }
    }
} else {
    echo "<center><strong><h1>Você não Tem permição para isso</h1></strong></center>";
    echo "<script>";
    echo "setTimeout(function() { window.location.href = '../index.php?page=login'; }, 3000);";
    echo "</script>";
}
