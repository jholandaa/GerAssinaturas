<?php
include 'conexao.php';

$query = "SELECT * FROM planos ORDER BY id";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Planos</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        table { border-collapse: collapse; width: 70%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <h1>Planos Disponíveis</h1>
    <a href="index.php">← Voltar ao início</a><br><br>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome do Plano</th>
            <th>Preço (R$)</th>
            <th>Duração (dias)</th>
        </tr>

        <?php
        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nome'] . "</td>";
                echo "<td>" . number_format($row['preco'], 2, ',', '.') . "</td>";
                echo "<td>" . $row['duracao_meses'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum plano encontrado.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
