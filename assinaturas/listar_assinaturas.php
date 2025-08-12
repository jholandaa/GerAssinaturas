<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexao.php';

$usuario_id = $_SESSION['usuario_id'];

$sql = "
    SELECT a.id, 
           p.nome AS plano, 
           p.preco, 
           p.duracao_meses, 
           a.data_inicio, 
           a.data_fim,
           a.status
    FROM assinaturas a
    JOIN planos p ON a.plano_id = p.id
    WHERE a.usuario_id = $1
    ORDER BY a.data_inicio DESC
";
$result = pg_query_params($conn, $sql, array($usuario_id));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Assinaturas - HNL</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #000000, #001f3f);
            font-family: Arial, sans-serif;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        header {
            background: rgba(0,0,0,0.85);
            padding: 15px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.8);
        }
        header h1 {
            margin: 0;
            color: #00aaff;
        }
        header nav a {
            color: #ffffff;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }
        header nav a:hover {
            color: #00aaff;
        }
        table {
            width: 80%;
            margin-top: 30px;
            border-collapse: collapse;
            background: rgba(0,0,0,0.7);
            border-radius: 8px;
            overflow: hidden;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #444;
        }
        table th {
            background: #001f3f;
            color: #00aaff;
        }
        .status-cancelada {
            color: #ff4444;
            font-weight: bold;
        }
        .btn-cancelar {
            background: #ff4444;
            padding: 6px 12px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }
        .btn-cancelar:hover {
            background: #cc0000;
        }
    </style>
</head>
<body>
<header>
    <h1>HNL - Minhas Assinaturas</h1>
    <nav>
        <a href="dashboard.php">Início</a>
        <a href="cadastrar_assinatura.php">Nova Assinatura</a>
        <a href="logout.php">Sair</a>
    </nav>
</header>

<?php
if (isset($_SESSION['msg'])) {
    echo "<p style='margin-top:20px; color:yellow;'>" . $_SESSION['msg'] . "</p>";
    unset($_SESSION['msg']);
}
?>

<table>
    <tr>
        <th>Plano</th>
        <th>Preço</th>
        <th>Duração (meses)</th>
        <th>Data Início</th>
        <th>Data Fim</th>
        <th>Status</th>
        <th>Ação</th>
    </tr>
<?php
if (pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['plano']) . "</td>";
        echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
        echo "<td>" . htmlspecialchars($row['duracao_meses']) . "</td>";
        echo "<td>" . htmlspecialchars($row['data_inicio']) . "</td>";
        echo "<td>" . ($row['data_fim'] ?? '-') . "</td>";
        echo "<td>" . ($row['status'] === 'cancelada'
                        ? '<span class="status-cancelada">Cancelada</span>'
                        : 'Ativa') . "</td>";
        
        if ($row['status'] === 'ativa') {
            echo "<td><a class='btn-cancelar' href='encerrar_assinatura.php?id=" . $row['id'] . "' onclick=\"return confirm('Tem certeza que deseja cancelar esta assinatura?');\">Cancelar</a></td>";
        } else {
            echo "<td>-</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>Nenhuma assinatura encontrada.</td></tr>";
}
?>
</table>
</body>
</html>

