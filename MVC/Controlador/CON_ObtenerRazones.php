<?php
require_once('../controlador/conexion_db.php');


$queryString = "SELECT * FROM razones";
$objQuery = $conn->prepare($queryString);
$objQuery->execute();
$razones = $objQuery->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($razones);
die();
?>