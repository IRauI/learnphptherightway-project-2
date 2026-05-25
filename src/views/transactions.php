<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $transactions = $this->params['transactions'];
                    foreach($transactions as $transaction):
                ?>
                <tr>
                    <td><?php echo $transaction['date'];?></td>
                    <td><?php echo $transaction['check_id'];?></td>
                    <td><?php echo $transaction['description'];?></td>
                    <td style="color:<?php echo $transaction['amount'][1] == '-' ? 'red' : 'green'; ?>"><?php echo trim($transaction['amount'],'"');?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?php echo $this->params['income']; ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?php echo $this->params['expense']; ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php echo $this->params['total']; ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
