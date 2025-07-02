<?php
require_once 'CRUD-PHP-FILES/connection.php';
$sql = 'SELECT * FROM usuarios';
$stmt = $pdo->prepare($sql);
$result = $stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="add">
        <a href="CRUD-PHP-FILES/create.php">Adicionar usuário</a>
    </div>
    <form method="GET">
            <table border="1" class="table">
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>SOBRENOME</th>
                    <th>EMAIL</th>
                    <th>AÇÕES</th>
                </tr>
                <?php if($data):?>
                <?php foreach($data as $linhas): ?>
                
                <tr>
                    <td class="TD-PHP"><?=htmlspecialchars($linhas->ID)?></td>
                    <td class="TD-PHP"><?=htmlspecialchars($linhas->NOME)?></td>
                    <td class="TD-PHP"><?=htmlspecialchars($linhas->SOBRENOME)?></td>
                    <td class="TD-PHP"><?=htmlspecialchars($linhas->EMAIL)?></td>
                    <td>
                        <a href="CRUD-PHP-FILES/update.php?ID=<?=$linhas->ID?>" onclick="return confirm('Editar usuário do ID:<?=htmlspecialchars($linhas->ID)?> ?')">Editar</a>
                        <a href="CRUD-PHP-FILES/delete.php?ID=<?=$linhas->ID?>" onclick="return confirm('Excluir usuário do ID:<?=htmlspecialchars($linhas->ID)?> ?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                    <tr> Nenhum registro encontrado</tr>
                <?php endif;?>
            </table>
    </form>
</body>
</html>