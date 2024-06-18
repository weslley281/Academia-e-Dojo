<div id="order" class="col-md-8 col-12">
    <div class="card mt-4">
        <div class="card-header">
            <h3>Resumo do Pedido</h3>
        </div>
        <form class="container" action="controllers/SalesRecordController.php?action=discount" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($sale_data["id"]) ?>">
            <div class="form-group">
                <label for="discount">Desconto:</label>
                <input type="number" id="discount" name="discount" value="0" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-secondary" type="submit">Efetuar Desconto</button>
            </div>

        </form>
        <?php if ($total_amount_paid) { ?>
            <form class="container" action="controllers/SalesPaymentItemController.php?action=clean" method="post">
                <input type="hidden" name="sale_id" value="<?= htmlspecialchars($sale_data["id"]) ?>">
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">Limpar Pagamentos</button>
                </div>
            </form>
        <?php } ?>
        <div class="card-body">
            <?php
            $total = $sub_total - $sale_data["discount"];
            $defit = $total_amount_paid - $total;
            ?>
            <p>Subtotal: R$ <?= htmlspecialchars(number_format((float) $sub_total, 2, ',', '.')) ?></p>
            <p>Desconto: R$ <?= htmlspecialchars(number_format((float) $sale_data["discount"], 2, ',', '.')) ?></p>
            <p>Total: R$ <?= htmlspecialchars(number_format((float) $total, 2, ',', '.')) ?></p>
            <p>Pago: R$ <?= htmlspecialchars(number_format((float) $total_amount_paid, 2, ',', '.')) ?></p>
            <?php
            if ($total > $total_amount_paid) {
            ?>
                <p>Falta: R$ <?= htmlspecialchars(number_format((float) $defit, 2, ',', '.')) ?></p>
            <?php } else { ?>
                <p>Troco: R$ <?= htmlspecialchars(number_format((float) $defit, 2, ',', '.')) ?></p>
            <?php } ?>


            <?php if (($total_amount_paid + $sale_data["discount"]) >= $sub_total && $sale_data["student_id"] != "" && $sale_data["student_id"] != null) { ?>
                <!-- Finalizar Compra -->
                <form method="post" action="controllers/SalesRecordController.php?action=update">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($sale_data['id']) ?>">
                    <input type="hidden" name="cashier_id" value="<?= htmlspecialchars($sale_data['cashier_id']) ?>">
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($sale_data['user_id']) ?>">
                    <input type="hidden" name="student_id" value="<?= htmlspecialchars($sale_data['student_id']) ?>">
                    <input type="hidden" name="amount_paid" value="<?= htmlspecialchars($total_amount_paid) ?>">
                    <input type="hidden" name="change_sale" value="<?= htmlspecialchars($defit) ?>">
                    <input type="hidden" name="total" value="<?= htmlspecialchars($total) ?>">
                    <input type="hidden" name="status" value="processed">
                    <button type="submit" class="btn btn-success btn-lg btn-block">Finalizar Compra</button>
                </form>
            <?php } else { ?>
                <button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#finalize_sale">Finalizar Compra</button>
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" id="finalize_sale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Forma de Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="controllers/SalesPaymentItemController.php?action=create">
                    <input type="hidden" name="sale_id" value="<?= htmlspecialchars($sale_data['id']) ?>">

                    <div class="form-group">
                        <label for="payment_method_id">Método de Pagamento</label>
                        <select class="form-control" id="payment_method_id" name="payment_method_id">

                            <?php
                            $methodPayments = $methodPayment->getAll();
                            if (isset($methodPayments) && !empty($methodPayments)) {
                                foreach ($methodPayments as $item) {
                            ?>
                                    <option value="<?= htmlspecialchars($item["id"]) ?>"><?= htmlspecialchars($methods[$item["name"]]) ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount_paid">Quantidade</label>
                        <input type="number" class="form-control" id="amount_paid" name="amount_paid" placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class=" btn btn-primary">Salvar mudanças</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>