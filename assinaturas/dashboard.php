<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$usuario_nome = $_SESSION['usuario_nome'] ?? 'Usuário';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - HNL</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #000000, #001f3f);
            color: #fff;
        }
        header {
            background: rgba(0,0,0,0.9);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            z-index: 10;
        }
        header h1 {
            margin: 0;
            color: #00aaff;
        }
        header .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        header a {
            color: #fff;
            text-decoration: none;
            background: #00aaff;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        header a:hover {
            background: #0088cc;
        }
        .container {
            margin-top: 100px;
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 20px;
        }
        .card {
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            width: 250px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            transition: transform 0.2s, background 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            background: rgba(0, 0, 0, 0.85);
        }
        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #00aaff;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            transition: background 0.3s;
        }
        .card a:hover {
            background: #0088cc;
        }
    </style>
</head>
<body>
    <header>
        <h1>HNL</h1>
        <div class="user-info">
            <span>Bem-vindo(a), <?php echo htmlspecialchars($usuario_nome); ?></span>
            <a href="logout.php">Sair</a>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <h2>Minhas Assinaturas</h2>
            <p>Veja e gerencie suas assinaturas ativas e encerradas.</p>
            <a href="listar_assinaturas.php">Acessar</a>
        </div>
        <div class="card">
            <h2>Nova Assinatura</h2>
            <p>Escolha um plano e inicie uma nova assinatura.</p>
            <a href="cadastrar_assinatura.php">Assinar</a>
        </div>
        <div class="card">
            <h2>Relatórios</h2>
            <p>Visualize relatórios detalhados sobre assinaturas e faturamento.</p>
            <a href="relatorios.php">Ver Relatórios</a>
        </div>
    </div>
</body>
</html>
