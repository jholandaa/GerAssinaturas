<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexao.php';
include 'navbar.php';

// 1. Quantidade por status
$sqlStatus = "
    SELECT status, COUNT(*) AS total
    FROM assinaturas
    GROUP BY status
    ORDER BY status
";
$resStatus = pg_query($conn, $sqlStatus);

// 2. Faturamento total e ticket médio
$sqlFaturamento = "
    SELECT 
        COALESCE(SUM(valor), 0) AS faturamento_total,
        COALESCE(AVG(valor), 0) AS ticket_medio
    FROM pagamentos
";
$resFaturamento = pg_query($conn, $sqlFaturamento);
$faturamento = pg_fetch_assoc($resFaturamento);

// 3. Assinaturas por plano
$sqlPlanos = "
    SELECT p.nome AS plano, COUNT(a.id) AS total_assinaturas
    FROM assinaturas a
    JOIN planos p ON a.plano_id = p.id
    GROUP BY p.nome
    ORDER BY total_assinaturas DESC
";
$resPlanos = pg_query($conn, $sqlPlanos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4ff !important;
        margin: 0;
        padding: 80px 20px 20px 20px;
    }
    h1, h2 {
        color: #001f3f;
    }
    table {
        border-collapse: collapse;
        width: 60%;
        background: #fff;
        margin-bottom: 30px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }
    th {
        background-color: #001f3f;
        color: white;
    }
    p {
        font-size: 16px;
    }
    .valor {
        font-weight: bold;
        color: #0074D9;
    }
</style>

</head>
<body>

<h1>Relatórios</h1>

<h2>Assinaturas por Status</h2>
<table>
    <tr>
        <th>Status</th>
        <th>Total</th>
    </tr>
    <?php while ($row = pg_fetch_assoc($resStatus)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= $row['total'] ?></td>
        </tr>
    <?php } ?>
</table>

<h2>Faturamento Total</h2>
<p><strong>Total:</strong> <span class="valor">R$ <?= number_format($faturamento['faturamento_total'], 2, ',', '.') ?></span></p>
<p><strong>Ticket Médio:</strong> <span class="valor">R$ <?= number_format($faturamento['ticket_medio'], 2, ',', '.') ?></span></p>

<h2>Assinaturas por Plano</h2>
<table>
    <tr>
        <th>Plano</th>
        <th>Total de Assinaturas</th>
    </tr>
    <?php while ($row = pg_fetch_assoc($resPlanos)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['plano']) ?></td>
            <td><?= $row['total_assinaturas'] ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
