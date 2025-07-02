<?php

require_once 'connection.php';
$msgDelete = '';
$id = filter_input(INPUT_GET, 'ID');

$sql = 'DELETE FROM usuarios where ID = :id';
if(!empty($id)){
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $msgDelete = "Usuário DELETADO!";
    header("Location:../index.php");
    exit();
}

