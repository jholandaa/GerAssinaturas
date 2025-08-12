<?php

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "Felicidades.1";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Erro na conexão com o banco de dados.");
}
?>
