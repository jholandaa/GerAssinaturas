<?php
session_start();
require_once 'conexao.php';

$email = $_POST['email'] ?? '';

if (empty($email)) {
    echo "E-mail não informado.";
    exit;
}

$query = "SELECT * FROM usuarios WHERE email = $1";
$result = pg_query_params($conn, $query, array($email));

if (pg_num_rows($result) == 1) {
    $usuario = pg_fetch_assoc($result);
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    header("Location: dashboard.php");
    exit;
} else {
    echo "E-mail não encontrado. Por favor, registre uma conta.";
}
?>
