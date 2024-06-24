<?php
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION['type'] == "admin") {
    require_once __DIR__ . '/../models/SalesRecords.php';
    require_once __DIR__ . '/../models/Expiration.php';
    require_once __DIR__ . '/../models/SalesItem.php';
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../models/Class.php';

    // Instância da classe SalesRecord
    $salesRecord = new SalesRecord($conn);
    $expiration = new Expiration($conn);
    $saleItem = new SalesItem($conn);
    $class = new ClassModel($conn);

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

                    if (isset($saleItens) && !empty($saleItens)) { // Verifica se há classes para exibir
                        foreach ($saleItens as $item) {

                            //var_dump($item);
                            $classData = $class->getById($item["class_id"]);

                            //echo var_dump($expiration = $expiration->getBySaleAndUserId($item["class_id"], $data["student_id"]));
                            if ($expirations = $expiration->getBySaleAndUserId($item["class_id"], $data["student_id"])) {
                                //echo "Fazendo Mudanças";
                                //var_dump($expirations);
                                $expirationDate = $expirations["expirationDate"];
                                $expirationDateObj = new DateTime($expirationDate);
                                $currentDateObj = new DateTime();

                                //echo "<br>A data de exppiração do banco = $expirationDate é menor que a data atual?";
                                //var_dump($expirationDateObj < $currentDateObj, $expirationDateObj);
                                if ($expirationDateObj < $currentDateObj) {
                                    $expirationDateObj = $currentDateObj;
                                    //echo "<br>É menor sim";
                                }

                                $expirationDateObj->modify("+" . $classData["days"] . " days");
                                $expirationDate = $expirationDateObj->format('Y-m-d');
                                //echo "<br> nova data de expiração é?";
                                //var_dump($expirationDate);

                                $expirationDataObj = [
                                    "student_id" => $data["student_id"],
                                    "class_id" => $item["class_id"],
                                    "expirationDate" => $expirationDate
                                ];

                                $expiration->update($expirationDataObj, $expirations["id"]);

                                //echo "<br>Fiz Update";
                            } else {
                                $expirationDate = Date("Y-m-d");
                                //var_dump($expirationDate);

                                $expirationDateObj = new DateTime($expirationDate);
                                $expirationDateObj->modify("+" . $classData["days"] . " days");
                                $expirationDate = $expirationDateObj->format('Y-m-d');

                                $expirationData = [
                                    "student_id" => $data["student_id"],
                                    "class_id" => $item["class_id"],
                                    "expirationDate" => $expirationDate
                                ];

                                $expiration->create($expirationData);
                                //echo "<br>Fiz Create";
                            }
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
                    header("Location: ../index.php?page=financial&action=sell");
                } else {
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
