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
    window.onload = function() {
      window.print();
      setTimeout(function() {
        window.location.href = '../../index.php?page=financial&action=sell';
      }, 10000);
    };
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
require_once '../../utils/openssl.php';

define('ENCRYPTION_KEY', 'gotosao');
$user = new User($conn);

$class = new ClassModel($conn);
$salesRecord = new SalesRecord($conn);
$salesItem = new SalesItem($conn);
$methodPayment = new MethodPayment($conn);
$salesPaymentItem = new SalesPaymentItem($conn);
$expirationItem = new ExpirationItem($conn);

$gymData = $user->getById(1);
$salesData = $salesRecord->getLastProcessedSale();

$studentData = $user->getById($salesData["student_id"]);
$userData = $user->getById($salesData["user_id"]);

$objDate = new DateTime($salesData["saleDate"]);
$formattedDate = $objDate->format("d/m/Y H:i:s");

$formattedTotal = number_format((float) $salesData["total"], 2, ',', '.');
$formattedAmountPaid = number_format((float) $salesData["amount_paid"], 2, ',', '.');
$formattedDiscount = number_format((float) $salesData["discount"], 2, ',', '.');
$formattedChangeSale = number_format((float) $salesData["change_sale"], 2, ',', '.');

$methods = [
  "cash" => "Dinheiro",
  "credit" => "Crédito",
  "debit" => "Débito",
  "deposit" => "Depósito, Transferência ou PIX"
];


//var_dump($salesData);
?>

<body>
  <div class="container">
    <div class="receipt">
      <div class="receipt-header">
        <h1>Academia <?= htmlspecialchars($gymData["name"]) ?></h1>
        <p><strong>Recibo de Compra</strong></p>
      </div>
      <div class="receipt-body">
        <p><strong>Operador de caixa:</strong> <?= htmlspecialchars($userData["name"]) ?></p>
        <p><strong>Cliente:</strong> <?= htmlspecialchars($studentData["name"]) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($studentData["email"]) ?></p>
        <p><strong>Data da Compra:</strong> <?= htmlspecialchars($formattedDate) ?></p>
        <?php
        $salestens = $salesItem->getBySaleId($salesData["id"]);
        $counter = 0;

        if (isset($salestens) && !empty($salestens)) {

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
        }
        $salesPaymentItems = $salesPaymentItem->getBySaleId($salesData["id"]);
        $counter2 = 0;

        if (isset($salesPaymentItems) && !empty($salesPaymentItems)) { // Verifica se há classes para exibir
          foreach ($salesPaymentItems as $item) {
            $methodPaymentData = $methodPayment->getById($item["payment_method_id"]);
            $valorFormatado = number_format((float) $item['amount_paid'], 2, ',', '.');
            $counter2 += 1;
          ?>
            <p>
              <strong>Metodo de pagamento <?= htmlspecialchars($counter) ?>: </strong> <?= htmlspecialchars($methods[$methodPaymentData["name"]]) ?>
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
          <?= htmlspecialchars($gymData["address"]) ?> - <?= htmlspecialchars($gymData["complement"]) ?>
          <br>
          <?= htmlspecialchars($gymData["country"]) ?> - <?= htmlspecialchars($gymData["state"]) ?> - <?= htmlspecialchars($gymData["city"]) ?> - <?= htmlspecialchars($gymData["neighborhood"]) ?> - <?= htmlspecialchars($gymData["postalCode"]) ?>
          <br>
          Telefone: <?= htmlspecialchars($gymData["phone"]) ?>
        </p>
        <p>Desenvolvido por: Weslley Ferraz
          <br><i>www.engenheirosoftwareweslley.com.br</i>
        </p>
      </div>
    </div>
  </div>
</body>

</html>