<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Entrar - HNL</title>
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
        .login-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.8);
            text-align: center;
            width: 320px;
        }
        .login-container h1 {
            margin-bottom: 20px;
            font-size: 32px;
        }
        .login-container input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background: #111;
            color: #fff;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background: #00aaff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .login-container button:hover {
            background: #0088cc;
        }
        .login-container .register-link {
            margin-top: 20px;
            display: block;
            color: #00aaff;
            text-decoration: none;
            font-size: 14px;
        }
        .login-container .register-link:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>HNL</h1>
        <form method="post" action="login_process.php">
            <label for="email">Acesse sua conta com e-mail:</label><br><br>
            <input type="email" name="email" id="email" placeholder="email@exemplo.com" required><br>
            <button type="submit">Entrar</button>
        </form>
        <a class="register-link" href="registrar_usuario.php">Não tem uma conta? Criar nova conta</a>
        <div class="footer">
            © 2025 HNL - Plataforma de Assinaturas
        </div>
    </div>
</body>
</html>
