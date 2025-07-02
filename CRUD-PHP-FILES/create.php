<?php

require_once 'connection.php';

$msg = '';

$name = filter_input(INPUT_POST, 'nome');
$sobrenome = filter_input(INPUT_POST, 'sobrenome');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($name) && !empty($sobrenome) && !empty($email)){
        try{
        $sql = 'INSERT INTO usuarios (NOME,SOBRENOME,EMAIL) values (:name,:sobrenome, :email)';
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':sobrenome', $sobrenome);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        header("Location:../index.php");
        exit();

        }catch(PDOException $e){
            if(strpos($e->getMessage(), 'Duplicate') !== false){
                $msg = '<h4 style="color:red;font-family:Arial">Email já registrado!</h4>';
            }
        }
    }else{
        $msg = '<h4 style="color:red;font-family:Arial">Preencha os campos!</h4>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar</title>
    <link rel=stylesheet href="../CRUD-STYLE/create.css">
</head>
<body>
    <form method="POST">
        <a href="../index.php">Voltar</a>
        <div class="container">
                <?=$msg;?>
                <label>Nome:<input type="text" name="nome" class="INPUT-TEXT"/></label>
                <label>Sobrenome:<input type="text" name="sobrenome" class="INPUT-TEXT"/></label>
                <label>Email:<input type="text" name="email" class="INPUT-TEXT"/></label>
            <input type="submit" value="Adicionar">
        </div>
    </form>
</body>
</html>