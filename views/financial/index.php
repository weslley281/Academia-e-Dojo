<div class="container mt-5">
    <h1>Vendas</h1>

    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#abrir_caixa">
        <i class="fa-regular fa-face-grin-beam"></i> Abrir Caixa
    </button>

    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#fechar_caixa">
        <i class="fa-regular fa-face-sad-tear"></i> Fechar Caixa
    </button>

    <div class="container">
        <div class="row mt-5">
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 my-2">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="./images/venda.jpg" alt="Imagem de capa do card">
                    <div class="card-body">
                        <h5 class="card-title">Vender</h5>
                        <p class="card-text">Venda combo de planos</strong>.</p>
                        <a href="index.php?page=finance&action=sell" class="btn btn-primary"><i class="fa-solid fa-eye"></i> Visitar</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-4 my-2">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="./images/gasto.jpg" alt="Imagem de capa do card">
                    <div class="card-body">
                        <h5 class="card-title">Despesas</h5>
                        <p class="card-text">Registre suas dispesas</strong>.</p>
                        <a href="index.php?page=finance&action=sell" class="btn btn-primary"><i class="fa-solid fa-eye"></i> Visitar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="abrir_caixa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Você tem certeza que deseja abrir o Caixa?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="submit" value="<?=$_SESSION["user_id"]?>">
                        <div class="form-group">
                            <label for="cash">Saldo inicial Dinheiro</label>
                            <input type="text" id="cash" name="cash" class="form-control" oninput="formatarNumero(this)" value="0" required>
                            <small>Insira valores separados por pontos, exemplo <strong>"2.99"</strong></small>
                        </div>
                        <div class="form-group">
                            <label for="credit ">Saldo inicial Crédito</label>
                            <input type="text" id="credit" name="credit" class="form-control" oninput="formatarNumero(this)" value="0" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="debit">Saldo inicial Débito</label>
                            <input type="text" id="debit" name="debit" class="form-control" oninput="formatarNumero(this)" value="0" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="deposit">Saldo inicial Depósiti</label>
                            <input type="text" id="deposit" name="deposit" class="form-control" oninput="formatarNumero(this)" value="0" required readonly>
                        </div>
                        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary">Salvar mudanças</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
