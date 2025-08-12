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

// Busca assinatura + informação do plano
$q = "
    SELECT a.id, a.plano_id, a.status, p.duracao_meses
    FROM assinaturas a
    JOIN planos p ON a.plano_id = p.id
    WHERE a.id = $1 AND a.usuario_id = $2
";
$res = pg_query_params($conn, $q, array($assinatura_id, $usuario_id));

if (!$res) {
    $_SESSION['msg'] = "Erro ao buscar assinatura: " . pg_last_error($conn);
    header("Location: listar_assinaturas.php");
    exit;
}

if (pg_num_rows($res) === 0) {
    $_SESSION['msg'] = "Assinatura não encontrada ou não pertence a você.";
    header("Location: listar_assinaturas.php");
    exit;
}

$row = pg_fetch_assoc($res);
$duracao_meses = (int) $row['duracao_meses'];

$upd_sql = "
    UPDATE assinaturas
    SET status = 'ativa',
        data_inicio = CURRENT_DATE,
        data_fim = (CURRENT_DATE + ($1 * INTERVAL '1 month'))
    WHERE id = $2
";
$upd = pg_query_params($conn, $upd_sql, array($duracao_meses, $assinatura_id));

if ($upd && pg_affected_rows($upd) > 0) {
    $_SESSION['msg'] = "Assinatura reativada com sucesso.";
} else {
    $_SESSION['msg'] = "Erro ao reativar assinatura: " . pg_last_error($conn);
}

header("Location: listar_assinaturas.php");
exit;
