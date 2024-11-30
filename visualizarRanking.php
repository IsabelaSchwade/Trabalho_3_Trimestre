<?php
require_once __DIR__ . "/vendor/autoload.php"; // carrega as classes e dependências

$livros = Livro::findall(); // Corrigido para 'Livro'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Livros</title>
    <link rel="stylesheet" href="style.css">
    
       
    
</head>
<body>
<h1>Book Match &#10084;&#65039; &#x1F4D6;</h1>
<table border="1">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($livros as $livro) {
            echo "<tr>";
            echo "<td>{$livro->getNomeLivro()}</td>";

            // Exibe a imagem usando a tag <img> com o link armazenado
            echo "<td><img src='{$livro->getImagemLivro()}' alt='Imagem de {$livro->getNomeLivro()}' width='100' height='150'></td>";

            // Sistema de avaliação por estrelas
          

            // Ações de editar e excluir
            echo "<td>
                     <a href='visualizarLivro.php?idLivro={$livro->getIdLivro()}'>Visualizar livro</a> |
                    <a href='formEditarLivro.php?idLivro={$livro->getIdLivro()}'>Editar</a> |
                    <a href='excluirLivro.php?idLivro={$livro->getIdLivro()}'>Excluir</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<a href='formAddLivro.php'>Adicionar Livro</a>
</body>
</html>
