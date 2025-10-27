<?php
// views/financial/register_payment.php
if (isset($_SESSION["user_id"]) && in_array($_SESSION['type'], ['admin', 'instructor'])) {

    // Validação do ID da mensalidade
    if (!isset($_GET['fee_id']) || !filter_var($_GET['fee_id'], FILTER_VALIDATE_INT)) {
        echo renderAlert('danger', 'Erro!', 'ID de mensalidade inválido.');
        echo "<script>setTimeout(function() { window.location.href = 'index.php?page=monthly_fees'; }, 3000);</script>";
        exit;
    }

    $fee_id = $_GET['fee_id'];

    require_once __DIR__ . '/../../models/MonthlyFee.php';
    $monthlyFee = new MonthlyFee($conn);
    $fee = $monthlyFee->getById($fee_id);

    if (!$fee) {
        echo renderAlert('danger', 'Erro!', 'Mensalidade não encontrada.');
        echo "<script>setTimeout(function() { window.location.href = 'index.php?page=monthly_fees'; }, 3000);</script>";
        exit;
    }
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Registrar Pagamento de Mensalidade</h1>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Detalhes da Cobrança</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Aluno:</strong> <?php echo htmlspecialchars($fee['student_name']); ?></p>
                    <p><strong>Modalidade:</strong> <?php echo htmlspecialchars($fee['modality_name']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Data de Vencimento:</strong> <?php echo date('d/m/Y', strtotime($fee['due_date'])); ?></p>
                    <p><strong>Valor Devido:</strong> R$ <?php echo number_format($fee['amount_due'], 2, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Formulário de Pagamento</h5>
        </div>
        <div class="card-body">
            <form action="controllers/MonthlyFeeController.php?action=pay" method="POST">
                <input type="hidden" name="fee_id" value="<?php echo $fee['id']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="payment_date" class="form-label"><strong>Data do Pagamento</strong></label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="amount_paid" class="form-label"><strong>Valor Pago</strong></label>
                        <input type="number" step="0.01" class="form-control" id="amount_paid" name="amount_paid" value="<?php echo number_format($fee['amount_due'], 2, '.', ''); ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Confirmar Pagamento</button>
                <a href="index.php?page=monthly_fees" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<?php
} else {
    echo "<center><strong><h1>Você não tem permissão para acessar esta página.</h1></strong></center>";
    echo "<script>setTimeout(function() { window.location.href = './index.php?page=login'; }, 3000);</script>";
}
?>