<?php
// views/financial/monthly_fees.php
if (isset($_SESSION["user_id"]) && in_array($_SESSION['type'], ['admin', 'instructor'])) {
    
    require_once __DIR__ . '/../../models/MonthlyFee.php';
    $monthlyFee = new MonthlyFee($conn);

    // Buscar mensalidades pendentes e atrasadas
    $pending_fees = $monthlyFee->getByStatus('pending');
    $overdue_fees = $monthlyFee->getByStatus('overdue');

?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Gestão de Mensalidades</h1>

    <!-- Seção de Mensalidades Atrasadas -->
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Mensalidades Atrasadas</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($overdue_fees)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>Modalidade</th>
                                <th>Vencimento</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($overdue_fees as $fee): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fee['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($fee['modality_name']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($fee['due_date'])); ?></td>
                                    <td>R$ <?php echo number_format($fee['amount_due'], 2, ',', '.'); ?></td>
                                    <td>
                                        <a href="index.php?page=register_payment&fee_id=<?php echo $fee['id']; ?>" class="btn btn-sm btn-success">Registrar Pagamento</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">Nenhuma mensalidade atrasada encontrada.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Seção de Mensalidades Pendentes -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Mensalidades Pendentes</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($pending_fees)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>Modalidade</th>
                                <th>Vencimento</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_fees as $fee): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fee['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($fee['modality_name']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($fee['due_date'])); ?></td>
                                    <td>R$ <?php echo number_format($fee['amount_due'], 2, ',', '.'); ?></td>
                                    <td>
                                        <a href="index.php?page=register_payment&fee_id=<?php echo $fee['id']; ?>" class="btn btn-sm btn-success">Registrar Pagamento</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">Nenhuma mensalidade pendente encontrada.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
} else {
    echo "<center><strong><h1>Você não tem permissão para acessar esta página.</h1></strong></center>";
    echo "<script>setTimeout(function() { window.location.href = './index.php?page=login'; }, 3000);</script>";
}
?>