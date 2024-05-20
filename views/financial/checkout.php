<h1 class="text-center">Checkout de Caixa</h1>

<div class="row mt-5">
    <!-- Produtos -->
    <div class="col-md-8 col-12">
        <div class="card mt-4">
            <div class="card-header">
                <h3>Produtos</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Produto 1</td>
                            <td>2</td>
                            <td>R$ 50,00</td>
                            <td>R$ 100,00</td>
                        </tr>
                        <tr>
                            <td>Produto 2</td>
                            <td>1</td>
                            <td>R$ 80,00</td>
                            <td>R$ 80,00</td>
                        </tr>
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