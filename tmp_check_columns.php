<?php
// Este script PHP se conecta a la base de datos y muestra las columnas de la tabla "colaboradores".
$pdo = new PDO('mysql:host=localhost;dbname=capital_humano;charset=utf8mb4','root','07280408luis');
$stmt = $pdo->query('SHOW COLUMNS FROM colaboradores');
foreach ($stmt as $row) {
    echo implode(' | ', $row) . PHP_EOL;
}
