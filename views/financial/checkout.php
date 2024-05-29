<?php
$cashier_open = $cashier->getCashierOpenByIdUser($_SESSION["user_id"]);

if (!$salesRecord->countUserSalesByStatus($_SESSION["user_id"], "in_process")) {

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

    $salesRecord->create($data);
}

$sale_data = $salesRecord->getSaleInProcessByIdUser($_SESSION["user_id"]);
?>
<h1 class="text-center">Checkout</h1>

<div class="row mt-5">
    <!-- Produtos -->
    <div class="col-md-8 col-12">
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

    <!-- Informações do Cliente -->
    <div class="col-md-4 col-12">
        <div class="card mt-4">
            <div class="card-header">
                <h3>Informações do Cliente</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="nomeCliente">Nome</label>
                        <input type="text" class="form-control" id="nomeCliente" placeholder="Nome do Cliente">
                    </div>
                    <div class="form-group">
                        <label for="emailCliente">Email</label>
                        <input type="email" class="form-control" id="emailCliente" placeholder="Email do Cliente">
                    </div>
                    <div class="form-group">
                        <label for="telefoneCliente">Telefone</label>
                        <input type="tel" class="form-control" id="telefoneCliente" placeholder="Telefone do Cliente">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Resumo do Pedido -->
    <div class="col-md-8 col-12">
        <div class="card mt-4">
            <div class="card-header">
                <h3>Resumo do Pedido</h3>
            </div>
            <div class="card-body">
                <p>Subtotal: R$ 180,00</p>
                <p>Desconto: R$ 0,00</p>
                <p>Total: R$ 180,00</p>
                <button class="btn btn-success btn-lg btn-block">Finalizar Compra</button>
            </div>
        </div>
    </div>

    <!-- Opções de Pagamento -->
    <div class="col-md-4 col-12">
        <div class="card mt-4">
            <div class="card-header">
                <h3>Opções de Pagamento</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="metodoPagamento">Método de Pagamento</label>
                        <select class="form-control" id="metodoPagamento">
                            <option>Cartão de Crédito</option>
                            <option>Cartão de Débito</option>
                            <option>Dinheiro</option>
                            <option>PIX</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="numeroCartao">Número do Cartão</label>
                        <input type="text" class="form-control" id="numeroCartao" placeholder="Número do Cartão">
                    </div>
                    <div class="form-group">
                        <label for="validadeCartao">Validade</label>
                        <input type="text" class="form-control" id="validadeCartao" placeholder="MM/AA">
                    </div>
                    <div class="form-group">
                        <label for="codigoSeguranca">Código de Segurança</label>
                        <input type="text" class="form-control" id="codigoSeguranca" placeholder="CVC">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>