<?php
session_start();
require_once 'conexao.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$plano_id = $_POST['plano_id'] ?? null;

if (!$usuario_id || !$plano_id) {
    echo "Dados inválidos.";
    exit;
}

$sql = "CALL registrar_assinatura($1, $2)";
$result = pg_query_params($conn, $sql, array($usuario_id, $plano_id));

if ($result) {
    echo "<p>Assinatura registrada com sucesso!</p>";
} else {
    echo "<p>Erro ao registrar assinatura.</p>";
}

echo '<a href="dashboard.php">← Voltar</a>';
?>
