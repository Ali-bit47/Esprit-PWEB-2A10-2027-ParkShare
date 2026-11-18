<?php
// Configuration PDO. Modifiez ces valeurs selon votre environnement.
$host = 'localhost';
$dbname = 'parkshare';
$username = 'root';
$password = '';

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    // Le site peut encore afficher les données de démonstration.
    $db = null;
}
