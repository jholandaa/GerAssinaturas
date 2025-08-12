<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = (int) $_SESSION['usuario_id'];
$assinatura_id = isset($_POST['assinatura_id']) ? (int) $_POST['assinatura_id'] : (isset($_GET['id']) ? (int) $_GET['id'] : null);

if (!$assinatura_id) {
    $_SESSION['msg'] = "ID de assinatura inválido.";
    header("Location: listar_assinaturas.php");
    exit;
}

$check = pg_query_params($conn,
    "SELECT id, status FROM assinaturas WHERE id = $1 AND usuario_id = $2",
    array($assinatura_id, $usuario_id)
);

if (!$check) {
    $err = pg_last_error($conn);
    $_SESSION['msg'] = "Erro ao validar assinatura: $err";
    header("Location: listar_assinaturas.php");
    exit;
}

if (pg_num_rows($check) === 0) {
    $_SESSION['msg'] = "Assinatura não encontrada ou não pertence a você.";
    header("Location: listar_assinaturas.php");
    exit;
}

$row = pg_fetch_assoc($check);
$current_status = $row['status'] ?? null;

if ($current_status === 'cancelada') {
    $_SESSION['msg'] = "Essa assinatura já está cancelada.";
    header("Location: listar_assinaturas.php");
    exit;
}

$upd = pg_query_params($conn,
    "UPDATE assinaturas SET status = 'cancelada', data_fim = CURRENT_DATE WHERE id = $1",
    array($assinatura_id)
);

if ($upd && pg_affected_rows($upd) > 0) {
    $_SESSION['msg'] = "Assinatura cancelada com sucesso.";
} else {
    $err = pg_last_error($conn);
    $_SESSION['msg'] = "Erro ao cancelar assinatura: $err";
}

header("Location: listar_assinaturas.php");
exit;
