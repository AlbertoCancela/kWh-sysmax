<?php
// test_conexion.php
require_once '../controller/DB.php';

$conexion = new Connection(false); // false = conexión real, no modo testing

$db = $conexion->getConnection();

if ($db instanceof PDO) {
    echo "✅ Conexión exitosa a SQLite.";
} else {
    echo "❌ No se pudo conectar.";
}
