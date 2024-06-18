<div id="report">
    <table id="minhaTabela" class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Usuário</th>
                <th>Estudante</th>
                <th>Desconto</th>
                <th>Pago</th>
                <th>Troco</th>
                <th>Total</th>
                <th>Estatus</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $salesRecordDatas = $salesRecord->getAll();

            if (isset($salesRecordDatas) && !empty($salesRecordDatas)) {
                foreach ($salesRecordDatas as $item) {
                    if ($item['status'] != "in_process") {

                        $userData = $user->getById($item['user_id']);
                        $userName = explode(" ", $userData["name"]);

                        $studentData = $user->getById($item['student_id']);
                        $studentName = explode(" ", $studentData["name"]);
            ?>
                        <tr>
                            <td><?= htmlspecialchars($item['cashier_id']) ?></td>
                            <td><?= htmlspecialchars($userName[0]) ?></td>
                            <td><?= htmlspecialchars($studentName[0]) ?></td>
                            <td><?= htmlspecialchars($item['discount']) ?></td>
                            <td><?= htmlspecialchars($item['amount_paid']) ?></td>
                            <td><?= htmlspecialchars($item['change_sale']) ?></td>
                            <td><?= htmlspecialchars($item['total']) ?></td>
                            <td><?= htmlspecialchars($item['status']) ?></td>
                            <td><?= htmlspecialchars($item['saleDate']) ?></td>
                        </tr>
            <?php }
                }
            } ?>
        </tbody>
    </table>
</div>