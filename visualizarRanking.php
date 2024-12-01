<?php
 require_once __DIR__ . "/vendor/autoload.php";// carrega as classes e dependências

// Consulta todos os livros, ordenando pela soma das avaliações
$conexao = new MySQL();
$sql = "
    SELECT livro.idLivro, livro.nomeLivro, livro.imagemLivro, 
           COALESCE(SUM(ranking.avaliaçao), 0) AS totalAvaliacoes
    FROM livro
    LEFT JOIN ranking ON livro.idLivro = ranking.idDoLivro
    GROUP BY livro.idLivro
    ORDER BY totalAvaliacoes DESC
";
$livros = $conexao->consulta($sql);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking dos Livros</title>
</head>
<body>
<h1>Ranking de Livros &#10084;&#65039; &#x1F4D6;</h1>
<table border="1">
    <thead>
        <tr>
            <th>Posição</th>
            <th>Nome</th>
            <th>Imagem</th>
            <th>Avaliação Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $posicao = 1; // Inicializa a posição para classificação
        foreach($livros as $livro){
            echo "<tr>";
            echo "<td>{$posicao}º</td>"; // Exibe a posição do livro
            echo "<td>{$livro['nomeLivro']}</td>";
            echo "<td><img src='{$livro['imagemLivro']}' alt='Imagem de {$livro['nomeLivro']}' width='100' height='150'></td>";
            echo "<td>{$livro['totalAvaliacoes']}</td>"; // Exibe a soma das avaliações
            echo "</tr>";
            $posicao++; // Incrementa a posição
        }
        ?>
    </tbody>
</table>

</body>
</html>
