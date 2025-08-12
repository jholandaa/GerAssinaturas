<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$nome = $_SESSION['usuario_nome'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Início - HNL</title>
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
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.9);
            text-align: center;
            width: 350px;
            animation: fadeIn 1s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .container h1 {
            margin-bottom: 20px;
            font-size: 26px;
        }
        .container a {
            display: block;
            margin: 12px 0;
            padding: 12px;
            background: #00aaff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .container a:hover {
            background: #0088cc;
        }
        .logout {
            margin-top: 20px;
            font-size: 14px;
            color: #ccc;
        }
        .logout a {
            color: #ff5555;
            text-decoration: none;
        }
        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</h1>
        <a href="listar_assinaturas.php">Minhas Assinaturas</a>
        <a href="cadastrar_assinatura.php">Nova Assinatura</a>
        <div class="logout">
            <a href="logout.php">Sair</a>
        </div>
    </div>
</body>
</html>
