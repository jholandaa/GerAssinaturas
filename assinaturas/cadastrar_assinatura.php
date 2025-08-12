<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once "conexao.php";

$sql = "SELECT * FROM planos ORDER BY nome";
$result = pg_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Assinatura - HNL</title>
    <style>
        body {
            margin:0;
            padding:0;
            background:linear-gradient(135deg, #000000, #001f3f);
            font-family:Arial, sans-serif;
            color:#fff;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }
        .container {
            background:rgba(0,0,0,0.85);
            padding:30px;
            border-radius:10px;
            width:90%;
            max-width:400px;
            box-shadow:0 0 20px rgba(0,0,0,0.9);
            animation:fadeIn 0.7s ease;
        }
        @keyframes fadeIn {
            from {opacity:0;transform:translateY(-20px);}
            to {opacity:1;transform:translateY(0);}
        }
        h1 {
            text-align:center;
            margin-bottom:20px;
        }
        form select, form button {
            width:100%;
            padding:12px;
            margin:10px 0;
            border:none;
            border-radius:5px;
            font-size:16px;
        }
        select {
            background:#222;
            color:#fff;
        }
        button {
            background:#00aaff;
            color:#fff;
            cursor:pointer;
            transition:background 0.3s ease;
        }
        button:hover {
            background:#0088cc;
        }
        .back {
            text-align:center;
            margin-top:10px;
        }
        .back a {
            color:#ccc;
            text-decoration:none;
        }
        .back a:hover {
            text-decoration:underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nova Assinatura</h1>
        <form method="post" action="salvar_assinatura.php">
            <select name="plano_id" required>
                <option value="">Selecione um plano</option>
                <?php while ($row = pg_fetch_assoc($result)): ?>
                <option value="<?= $row['id'] ?>">
                    <?= htmlspecialchars($row['nome']) ?> (R$<?= $row['preco'] ?>)
                </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Assinar</button>
        </form>
        <div class="back">
            <a href="dashboard.php">← Voltar ao início</a>
        </div>
    </div>
</body>
</html>
