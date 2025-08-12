<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';

    if (empty($nome) || empty($email)) {
        echo "Preencha todos os campos.";
        exit;
    }

    $checkQuery = "SELECT * FROM usuarios WHERE email = $1";
    $checkResult = pg_query_params($conn, $checkQuery, array($email));

    if (pg_num_rows($checkResult) > 0) {
        echo "E-mail já cadastrado.";
        exit;
    }

    $insertQuery = "INSERT INTO usuarios (nome, email) VALUES ($1, $2)";
    $result = pg_query_params($conn, $insertQuery, array($nome, $email));

    if ($result) {
        header("Location: login.php");
        exit;
    } else {
        echo "Erro ao registrar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta - HNL</title>
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
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.8);
            text-align: center;
            width: 320px;
        }
        .container h1 {
            margin-bottom: 20px;
            font-size: 28px;
        }
        .container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background: #111;
            color: #fff;
        }
        .container button {
            width: 100%;
            padding: 12px;
            background: #00aaff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .container button:hover {
            background: #0088cc;
        }
        .container .back-link {
            margin-top: 20px;
            display: block;
            color: #00aaff;
            text-decoration: none;
            font-size: 14px;
        }
        .container .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Criar Conta</h1>
        <form method="post">
            <input type="text" name="nome" placeholder="Seu nome" required><br>
            <input type="email" name="email" placeholder="Seu e-mail" required><br>
            <button type="submit">Registrar</button>
        </form>
        <a class="back-link" href="login.php">Voltar ao login</a>
    </div>
</body>
</html>
