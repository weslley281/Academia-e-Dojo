<?php
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION['type'] == "admin") {
    require_once __DIR__ . '/../models/SalesRecords.php';
    require_once __DIR__ . '/../models/Expiration.php';
    require_once __DIR__ . '/../models/SalesItem.php';
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../models/Modality.php';
    require_once __DIR__ . '/../models/MonthlyFee.php';

    $salesRecord = new SalesRecord($conn);
    $expiration = new Expiration($conn);
    $saleItem = new SalesItem($conn);
    $modality = new Modality($conn);
    $monthlyFee = new MonthlyFee($conn);

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
                "cashier_id" => htmlspecialchars($post["cashier_id"]),
                "user_id" => $_SESSION["user_id"],
                "student_id" => htmlspecialchars($post["student_id"]),
                "discount" => htmlspecialchars($post["discount"] ?? 0),
                "amount_paid" => htmlspecialchars($post["amount_paid"] ?? 0),
                "change_sale" => htmlspecialchars($post["change_sale"] ?? 0),
                "total" => htmlspecialchars($post["total"] ?? 0),
                "status" => htmlspecialchars($post["status"]),
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
                    $saleItens = $saleItem->getBySaleId($id);

                    if (isset($saleItens) && !empty($saleItens)) {
                        foreach ($saleItens as $item) {
                            $modalityData = $modality->getById($item["modality_id"]);

                            // Lógica para criar a próxima mensalidade
                            // A data de vencimento será calculada com base na data de hoje + os dias do plano
                            $dueDate = new DateTime();
                            $dueDate->modify("+" . $modalityData["days"] . " days");

                            $monthlyFeeData = [
                                "student_id" => $data["student_id"],
                                "modality_id" => $item["modality_id"],
                                "due_date" => $dueDate->format('Y-m-d'),
                                "amount_due" => $modalityData['value'],
                                "status" => 'pending'
                            ];

                            $monthlyFee->create($monthlyFeeData);
                        }
                    }

                    echo "<script>";
                    echo "setTimeout(function() { window.location.href = '../views/financial/receipt.php'; }, 500);";
                    echo "</script>";
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
                    header("Location: ../index.php?page=financial&action=sell#client");
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
                    // Check if it's an AJAX request
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => 'Desconto aplicado com sucesso.']);
                        exit;
                    }
                    header("Location: ../index.php?page=financial&action=sell");
                } else {
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        http_response_code(500);
                        echo json_encode(['success' => false, 'message' => 'Erro ao aplicar desconto.']);
                        exit;
                    }
                    header("Location: ../index.php?page=financial&action=sell");
                }
                break;

            default:
                header("Location: ../index.php?page=financial&action=sell");
                break;
        }
    }
} else {
    echo "<center><strong><h1>Você não Tem permição para isso</h1></strong></center>";
    echo "<script>";
    echo "setTimeout(function() { window.location.href = '../index.php?page=login'; }, 3000);";
    echo "</script>";
}
