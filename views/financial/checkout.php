<?php
$cashier_open = $cashier->getCashierOpenByIdUser($_SESSION["user_id"]);

if (!$salesRecord->countUserSalesByStatus($_SESSION["user_id"], "in_process")) {
    echo "Eu executei";
    $data = [
        "cashier_id" => $cashier_open["id"],
        "user_id" => $_SESSION["user_id"],
        "student_id" => null,
        "amount_paid" => 0,
        "change_sale" => 0,
        "total" => 0,
        "paymentMethodId" => null,
        "status" => "in_process",
        "status" => htmlspecialchars('in_process' ?? ''),
    ];
    var_dump($data);

    $salesRecord->create($data);
}

$sale_data = $salesRecord->getSaleInProcessByIdUser($_SESSION["user_id"]);
$user_data = $user->getById($sale_data["student_id"]);
$total_amount_paid = $salesPaymentItem->getTotalAmountPaidBySaleId($sale_data["id"]);

$sub_total = 0;
$methods = [
    "cash" => "Dinheiro",
    "credit" => "Crédito",
    "debit" => "Débito",
    "deposit" => "Depósito, Transferência ou PIX"
];
?>
<h1 class="text-center">Checkout</h1>

<div class="row mt-5">
    <!-- Produtos -->
    <div class="col-md-12 col-12">
        <div class="card mt-4">
            <div class="card-header">
                <h3>Produtos</h3>
            </div>
            <div class="card-body">
                <form action="./controllers/SalesItemController.php?action=create" method="post">
                    <div class="form-group">
                        <label for="select_product">Selecionar Produto</label>
                        <div class="row">
                            <div class="col-11">
                                <input type="hidden" name="sale_id" value="<?= htmlspecialchars($sale_data["id"])  ?>">
                                <select class="form-control select_basic2" name="select_product" id="select_product">
                                    <?php
                                    $classes = $class->getAll(); // Obtém todas as classes do modelo

                                    if (isset($classes) && !empty($classes)) { // Verifica se há classes para exibir
                                        foreach ($classes as $class_item) {
                                            $get_user = $user->getById($class_item['idInstructor']);
                                            $valorFormatado = number_format((float) $class_item['value'], 2, ',', '.');
                                    ?>
                                            <option value="<?= htmlspecialchars($class_item['id']) ?>">
                                                <?= htmlspecialchars($class_item['name']) . " R$ " . $valorFormatado ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-cart-arrow-down"></i></button>
                            </div>
                        </div>

                    </div>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Turma</th>
                            <th>Professor</th>
                            <th>Preço Unitário</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $salesItems = $salesItem->getAll(); // Obtém todas as classes do modelo

                        if (isset($salesItems) && !empty($salesItems)) { // Verifica se há classes para exibir
                            foreach ($salesItems as $item) {
                                $class_item = $class->getById($item["class_id"]);
                                $sub_total += $class_item['value'];
                                $get_user = $user->getById($class_item['idInstructor']);
                                $valorFormatado = number_format((float) $class_item['value'], 2, ',', '.');
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($class_item['name']) ?></td>
                                    <td><?= htmlspecialchars($get_user["name"]) ?></td>
                                    <td>R$ <?= htmlspecialchars($valorFormatado) ?></td>
                                    <td>
                                        <form action="controllers/SalesItemController.php?action=delete" method="post">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($item["id"]) ?>">
                                            <button type="submit" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Resumo do Pedido -->
    <div class="col-md-8 col-12">
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
                <?php $total = ($sub_total - $total_amount_paid) - $sale_data["discount"]; ?>
                <p>Subtotal: R$ <?= htmlspecialchars(number_format((float) $sub_total, 2, ',', '.')) ?></p>
                <p>Desconto: R$ <?= htmlspecialchars(number_format((float) $sale_data["discount"], 2, ',', '.')) ?></p>
                <p>Total: R$ <?= htmlspecialchars(number_format((float) $total, 2, ',', '.')) ?></p>
                <button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#finalize_sale">Finalizar Compra</button>

                <!-- Finalizar Compra -->
                <form method="post" action="controllers/SalesRecordController.php?action=update">
                    <input type="hidden" name="cashier_id" value="<?= htmlspecialchars($sale_data['cashier_id']) ?>">
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($sale_data['user_id']) ?>">
                    <input type="hidden" name="student_id" value="<?= htmlspecialchars($sale_data['student_id']) ?>">
                    <input type="hidden" name="amount_paid" value="<?= htmlspecialchars($sale_data['amount_paid']) ?>">
                    <input type="hidden" name="change_sale" value="<?= htmlspecialchars($sale_data['change_sale']) ?>">
                    <input type="hidden" name="total" value="<?= htmlspecialchars($total) ?>">
                    <input type="hidden" name="" value="<?= htmlspecialchars($sale_data['status']) ?>">
                </form>
            </div>
        </div>
    </div>

    <!-- Informações do Cliente -->
    <div class="col-md-4 col-12">
        <div class="card mt-4">
            <div class="card-header">
                <h3>Informações do Cliente</h3>
            </div>
            <?php if (!$sale_data["student_id"]) { ?>
                <div class="card-body">
                    <form action="controllers/SalesRecordController.php?action=update_client" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($sale_data["id"]) ?>">
                            <label for="client">Cliente</label>
                            <select class="form-control select_basic2" name="client" id="client">
                                <?php
                                $users = $user->getAll();

                                if (isset($users) && !empty($users)) {
                                    foreach ($users as $item) {
                                ?>
                                        <option value="<?= htmlspecialchars($item['id']) ?>">
                                            <?= htmlspecialchars($item['id']) . ": " . $item['name'] ?>
                                        </option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Selecionar o Cliente</button>
                        </div>
                    </form>
                    <div class="form-group">
                        <label for="nomeCliente">Nome</label>
                        <input type="text" class="form-control" id="nomeCliente" placeholder="Nome do Cliente" readonly>
                    </div>
                    <div class="form-group">
                        <label for="emailCliente">Email</label>
                        <input type="email" class="form-control" id="emailCliente" placeholder="Email do Cliente" readonly>
                    </div>
                    <div class="form-group">
                        <label for="telefoneCliente">Telefone</label>
                        <input type="tel" class="form-control" id="telefoneCliente" placeholder="Telefone do Cliente" readonly>
                    </div>
                    </form>
                </div>
            <?php } else { ?>
                <div class="card-body">
                    <form action="controllers/SalesRecordController.php?action=update_client" method="post">
                        <div class="form-group">

                            <input type="hidden" name="id" value="<?= htmlspecialchars($sale_data["id"]) ?>">
                            <label for="client">Cliente</label>
                            <select class="form-control select_basic2" name="client" id="client">
                                <option value=""><?= htmlspecialchars($sale_data["student_id"]) . ": " . $user_data["name"] ?></option>
                                <?php
                                $users = $user->getAll();

                                if (isset($users) && !empty($users)) {
                                    foreach ($users as $item) {
                                        if ($item["id"] != $sale_data["student_id"]) {
                                ?>
                                            <option value="<?= htmlspecialchars($item['id']) ?>">
                                                <?= htmlspecialchars($item['id']) . ": " . $item['name'] ?>
                                            </option>
                                <?php }
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Selecionar o Cliente</button>
                        </div>
                    </form>
                    <div class="form-group">
                        <label for="nomeCliente">Nome</label>
                        <input type="text" class="form-control" id="nomeCliente" value="<?= htmlspecialchars($user_data['name']) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="emailCliente">Email</label>
                        <input type="email" class="form-control" id="emailCliente" value="<?= htmlspecialchars($user_data['email']) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="telefoneCliente">Telefone</label>
                        <input type="tel" class="form-control" id="telefoneCliente" value="<?= htmlspecialchars($user_data['phone']) ?>" readonly>
                    </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Modal -->
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
</div>