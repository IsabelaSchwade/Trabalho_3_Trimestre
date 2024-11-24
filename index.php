<?php
require_once __DIR__."/vendor/autoload.php"; // carrega as classes e dependencias uma unica vez

$livros= livro::findall();// pegando todas as festas do banco e armazenando na variavel $festa
// utiliza o findall pq pega todas as festas
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
    </tr>
    <?php
    foreach($livros as $livro){ // cria um loop para percorrer todas as festas, cada festa se torna na variavel $festa
        //para cada festa cria uma linha <tr> e varias colunas <td> onde coloca o nome, o endereço, etc
        echo "<tr>";
        echo "<td>{$livro->getNomeLivro()}</td>";
        echo "<td>{$festa->getimagemLivro()}</td>";
        echo "<td>
                <a href='formEdit.php?idFesta={$festa->getIdLivro()}'>Editar</a>
                <a href='excluir.php?idFesta={$festa->getIdLivro()}'>Excluir</a> 
             </td>";
        echo "</tr>";
    }
    ?>
</table>
<a href='formCad.php'>Adicionar Livro</a>
</body>
</html>