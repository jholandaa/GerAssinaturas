<?php
require_once 'conexao.php';

$query = "SELECT * FROM usuarios ORDER BY id";
$result = pg_query($conn, $query);

if (!$result) {
    echo "Erro ao buscar usuários.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ddd;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Usuários Cadastrados</h1>
    <a href="index.php">&larr; Voltar ao início</a>
    <br><br>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
        </tr>
        <?php
        while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".htmlspecialchars($row['id'])."</td>";
            echo "<td>".htmlspecialchars($row['nome'])."</td>";
            echo "<td>".htmlspecialchars($row['email'])."</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
