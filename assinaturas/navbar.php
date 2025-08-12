<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<style>
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #000;
    padding: 10px 30px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 100;
    box-shadow: 0 2px 5px rgba(0,0,0,0.5);
}
.navbar .logo {
    font-size: 24px;
    font-weight: bold;
    color: #00bfff;
    animation: fadeIn 2s ease forwards, pulse 4s infinite;
    opacity: 0;
}
@keyframes fadeIn {
    to { opacity: 1; }
}
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
.navbar nav a {
    color: #fff;
    text-decoration: none;
    margin-left: 20px;
    font-weight: 500;
    transition: color 0.3s ease;
}
.navbar nav a:hover {
    color: #00bfff;
}
body {
    padding-top: 60px; 
}
</style>

<div class="navbar">
    <div class="logo">HNL+</div>
    <nav>
        <a href="cadastrar_assinatura.php">Nova Assinatura</a>
        <a href="listar_assinaturas.php">Minhas Assinaturas</a>
        <a href="logout.php">Logout</a>
        <a href="relatorios.php">Relatórios</a>

    </nav>
</div>
