<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'conexao.php';

$usuario_id = $_SESSION['usuario_id'];
$plano_id = $_POST['plano_id'] ?? null;

$mensagem = "";
$sucesso = false;

if (!$plano_id) {
    $mensagem = "❌ Plano inválido.";
} else {
    // Chama a procedure registrar_assinatura(usuario_id, plano_id)
    $sql = "CALL registrar_assinatura($1, $2)";
    $result = pg_query_params($conn, $sql, array($usuario_id, $plano_id));

    if ($result) {
        $mensagem = "✅ Assinatura registrada com sucesso!";
        $sucesso = true;
    } else {
        $mensagem = "❌ Erro ao registrar assinatura.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registrar Assinatura - HNL</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #000000, #001f3f);
            font-family: Arial, sans-serif;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: rgba(0, 0, 0, 0.75);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.8);
            text-align: center;
            width: 400px;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .message {
            font-size: 18px;
            margin: 20px 0;
            color: <?php echo $sucesso ? '#00ff88' : '#ff5555'; ?>;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #00aaff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        a:hover {
            background: #0088cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>HNL</h1>
        <div class="message"><?php echo htmlspecialchars($mensagem); ?></div>
        <a href="listar_assinaturas.php">← Voltar ao painel</a>
    </div>
</body>
</html>
