<?php
require_once __DIR__."/vendor/autoload.php"; // carrega as classes e dependências

$livros = Livro::findall(); // Corrigido para 'Livro'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Livros</title>
</head>
<body>

<table>
    <tr>
        <td>Nome</td>
        <td>Imagem</td>
        <td>Ações</td>
    </tr>
    <?php
    foreach($livros as $livro){
        echo "<tr>";
        echo "<td>{$livro->getNomeLivro()}</td>";
        echo "<td><img src='{$livro->getimagemLivro()}' style='max-width:100px; max-height:100px;'></td>";
        echo "<td>
                <a href='formEditarLivro.php?idLivro={$livro->getIdLivro()}'>Editar</a>
                <a href='excluirLivro.php?idLivro={$livro->getIdLivro()}'>Excluir</a> 
             </td>";
        echo "</tr>";
    }
    ?>
</table>
<a href='formAddLivro.php'>Adicionar Livro</a>
</body>
</html>
