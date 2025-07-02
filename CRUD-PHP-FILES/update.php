<?php

require_once 'connection.php';

$nome = filter_input(INPUT_POST, 'nome');
$sobrenome = filter_input(INPUT_POST, 'sobrenome');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$id = filter_input(INPUT_GET, 'ID') ?? filter_input(INPUT_POST, 'ID');
$msg = '';
$autofill = [];

if(!empty($id)){
    $sql = 'SELECT * FROM usuarios where ID = :ID';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $id);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        $autofill = [
            'NOME' => $user['NOME'],
            'SOBRENOME' => $user['SOBRENOME'],
            'EMAIL' => $user['EMAIL']
        ];
    }

}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
    if (!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($id)){
        try{
        $sql = 'UPDATE usuarios set NOME = :nome, SOBRENOME = :sobrenome, EMAIL = :email WHERE ID = :id';
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':sobrenome', $sobrenome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id);

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
                <input type="hidden" name="ID" value="<?= htmlspecialchars($_GET['ID'] ?? '')?>">
                <label>Nome:<input type="text" name="nome" class="INPUT-TEXT" value="<?=htmlspecialchars($autofill['NOME'])?>"/></label>
                <label>Sobrenome:<input type="text" name="sobrenome" class="INPUT-TEXT" value="<?=htmlspecialchars($autofill['SOBRENOME'])?>" /></label>
                <label>Email:<input type="text" name="email" class="INPUT-TEXT" value="<?=htmlspecialchars($autofill['EMAIL'])?>"/></label>
            <input type="submit" value="Atualizar">
        </div>
    </form>
</body>
</html>