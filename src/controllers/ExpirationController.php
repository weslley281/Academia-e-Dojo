<?php
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION['type'] == "admin") {
    require_once __DIR__ . '/../models/Expiration.php';
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../models/MonthlyFee.php';

    $expiration = new Expiration($conn);
    $user = new User($conn);
    $monthlyFee = new MonthlyFee($conn);

    // Verifica o método HTTP
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        // Verifica a ação a ser executada
        $action = isset($_GET['action']) ? strtolower($_GET['action']) : '';

        // Função para criar o array de dados de usuário
        function getExpirationData($post)
        {
            return [
                "student_id" => htmlspecialchars($post["sale_id"] ?? ''),
                "modality_id" => htmlspecialchars($post["select_product"] ?? ''),
                "expirationDate" => htmlspecialchars($post["expirationDate"] ?? '')
            ];
        }

        switch ($action) {
            case 'create':
                $data = getExpirationData($_POST);
                if ($expiration->create($data)) {
                    header("Location: ../index.php?page=financial&action=sell");
                } else {
                    header("Location: ../index.php?page=financial&action=sell&info=error");
                }
                break;

            case 'update':
                if ($id === null) {
                    header("Location: ../index.php?page=financial&action=sell&info=invalid");
                    exit;
                }
                $data = getExpirationData($_POST);
                if ($expiration->update($data, $id)) {
                    header("Location: ../index.php?page=financial&action=sell&info=saved");
                } else {
                    header("Location: ../index.php?page=financial&action=sell");
                }
                break;

            case 'delete':
                if ($id === null) {
                    header("Location: ../index.php?page=financial&action=sell&info=invalid");
                    exit;
                }
                if ($expiration->delete($id)) {
                    header("Location: ../index.php?page=financial&action=sell&info=deleted");
                } else {
                    header("Location: ../index.php?page=financial&action=sell");
                }
                break;

            case 'validate':
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $password = $_POST['password'] ?? '';

                if (!$email || empty($password)) {
                    header("Location: ../index.php?page=validate&action=invalid_input");
                    exit;
                }

                $student = $user->getByEmail($email);

                // 1. Verifica se o aluno existe e a senha está correta
                if ($student && password_verify($password, $student['password'])) {
                    
                    // 2. Verifica o status das mensalidades
                    $fees = $monthlyFee->getByStudentId($student['id']);
                    $hasPendingFees = false;
                    foreach ($fees as $fee) {
                        if ($fee['status'] === 'pending' || $fee['status'] === 'overdue') {
                            $hasPendingFees = true;
                            break; // Encontrou uma pendência, não precisa checar mais
                        }
                    }

                    if ($hasPendingFees) {
                        // 3a. Bloqueia a entrada se houver pendências
                        $_SESSION['validated_student_name'] = $student['name'];
                        header("Location: ../index.php?page=validate&action=payment_due");
                    } else {
                        // 3b. Permite a entrada se estiver tudo em dia
                        $_SESSION['validated_student_name'] = $student['name'];
                        header("Location: ../index.php?page=validate&action=success");
                    }

                } else {
                    // Falha no login
                    header("Location: ../index.php?page=validate&action=fail");
                }
                exit;
                break;

            default:
                header("Location: ../index.php?page=financial&action=sell&info==unknown");
                break;
        }
    }
} else {
    echo "<center><strong><h1>Você não Tem permição para isso</h1></strong></center>";
    echo "<script>";
    echo "setTimeout(function() { window.location.href = '../index.php?page=login'; }, 3000);";
    echo "</script>";
}
