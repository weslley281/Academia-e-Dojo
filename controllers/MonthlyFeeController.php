<?php
// controllers/MonthlyFeeController.php
session_start();

if (isset($_SESSION["user_id"]) && in_array($_SESSION['type'], ['admin', 'instructor'])) {
    
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../models/MonthlyFee.php';

    $monthlyFee = new MonthlyFee($conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'pay':
                // Validação dos dados recebidos
                $fee_id = filter_input(INPUT_POST, 'fee_id', FILTER_VALIDATE_INT);
                $payment_date = $_POST['payment_date'] ?? null;
                $amount_paid = filter_input(INPUT_POST, 'amount_paid', FILTER_VALIDATE_FLOAT);

                if (!$fee_id || !$payment_date || $amount_paid === false) {
                    // Redirecionar com erro se a validação falhar
                    header("Location: ../index.php?page=monthly_fees&action=fail_validation");
                    exit;
                }

                // Prepara os dados para atualização
                $paymentData = [
                    'payment_date' => $payment_date,
                    'amount_paid' => $amount_paid,
                    'status' => 'paid'
                ];

                // Tenta atualizar o pagamento
                if ($monthlyFee->updatePayment($fee_id, $paymentData)) {
                    header("Location: ../index.php?page=monthly_fees&action=payment_success");
                } else {
                    header("Location: ../index.php?page=monthly_fees&action=payment_fail");
                }
                break;

            default:
                // Ação desconhecida
                header("Location: ../index.php?page=monthly_fees&action=unknown_action");
                break;
        }
    }

} else {
    // Erro de permissão
    echo "<center><strong><h1>Você não tem permissão para executar esta ação.</h1></strong></center>";
    echo "<script>setTimeout(function() { window.location.href = '../index.php?page=login'; }, 3000);</script>";
}
?>