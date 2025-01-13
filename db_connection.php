<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'help';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_errno) {
    die("Erro na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>