<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recibo</title>
  <link rel="stylesheet" href="../../libs/bootstrap/bootstrap.css">
  <style>
    .receipt {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
    }

    .receipt-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .receipt-footer {
      text-align: center;
      margin-top: 20px;
      font-size: 0.9em;
      color: #777;
    }
  </style>
  <script>
    //Função para imprimir a página quando ela for carregada
    // window.onload = function() {
    //   window.print();
    // };
  </script>
</head>

<?php
require_once '../../models/User.php';
require_once '../../models/SalesRecords.php';
require_once '../../models/SalesItem.php';
require_once '../../models/MethodPayment.php';
require_once '../../models/SalesPaymentItem.php';
require_once '../../models/ExpirationItem.php';
require_once '../../models/Class.php';

$user = new User($conn);


$class = new ClassModel($conn);
$salesRecord = new SalesRecord($conn);
$salesItem = new SalesItem($conn);
$methodPayment = new MethodPayment($conn);
$salesPaymentItem = new SalesPaymentItem($conn);
$expirationItem = new ExpirationItem($conn);

$userData = $user->getById(1);
$salesData = $salesRecord->getLastProcessedSale();

$objDate = new DateTime($salesData["saleDate"]);
$formattedDate = $objDate->format("d/m/Y H:i:s");

$formattedTotal = number_format((float) $salesData["total"], 2, ',', '.');
$formattedAmountPaid = number_format((float) $salesData["amount_paid"], 2, ',', '.');
$formattedDiscount = number_format((float) $salesData["discount"], 2, ',', '.');
$formattedChangeSale = number_format((float) $salesData["change_sale"], 2, ',', '.');

var_dump($salesData);
?>

<body>
  <div class="container">
    <div class="receipt">
      <div class="receipt-header">
        <h1>Academia <?= htmlspecialchars($userData["name"]) ?></h1>
        <p><strong>Recibo de Compra</strong></p>
      </div>
      <div class="receipt-body">
        <p><strong>Nome:</strong> Weslley Henrique Vieira Ferraz</p>
        <p><strong>Data da Compra:</strong> <?= htmlspecialchars($formattedDate) ?></p>
        <?php
        $salestens = $salesItem->getBySaleId($salesData["id"]);

        if (isset($salestens) && !empty($salestens)) { // Verifica se há classes para exibir
          $counter = 0;
          foreach ($salestens as $item) {
            $classData = $class->getById($item["class_id"]);
            $valorFormatado = number_format((float) $classData['value'], 2, ',', '.');
            $counter += 1;
        ?>
            <p>
              <strong>Plano <?= htmlspecialchars($counter) ?>: </strong> <?= htmlspecialchars($classData["name"]) ?> por <?= htmlspecialchars($classData["days"]) ?> dias
              <br>
              <strong>Valor: </strong> R$ <?= htmlspecialchars($valorFormatado) ?>
              <hr>
            </p>
        <?php }
        } ?>
        <p><strong>Total:</strong> R$ <?= htmlspecialchars($formattedTotal) ?></p>
        <p><strong>Total Pago:</strong> R$ <?= htmlspecialchars($formattedAmountPaid) ?></p>
        <p><strong>Desconto:</strong> R$ <?= htmlspecialchars($formattedDiscount) ?></p>
        <p><strong>Troco:</strong> R$ <?= htmlspecialchars($formattedChangeSale) ?></p>
      </div>
      <div class="receipt-footer">
        <p>Obrigado pela sua compra!</p>
        <p>
          <?= htmlspecialchars($userData["address"]) ?> - <?= htmlspecialchars($userData["complement"]) ?>
          <br>
          <?= htmlspecialchars($userData["country"]) ?> - <?= htmlspecialchars($userData["state"]) ?> - <?= htmlspecialchars($userData["city"]) ?> - <?= htmlspecialchars($userData["neighborhood"]) ?> - <?= htmlspecialchars($userData["postalCode"]) ?>
          <br>
          Telefone: <?= htmlspecialchars($userData["phone"]) ?>
        </p>
      </div>
    </div>
  </div>
</body>

</html>