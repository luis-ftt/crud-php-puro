<?php

require_once 'enviroment.php';

$msg = '';
$dsn = "mysql:host=$ENV_HOST;dbname=$ENV_DBNAME";

try{
    $pdo = new PDO($dsn, $ENV_USERNAME,$ENV_PASSWORD);
} catch (PDOException $e){
    $msg = "Erro na conexão: " .$e->getMessage();
}