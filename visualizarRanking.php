<?php
require_once __DIR__ . "/vendor/autoload.php"; // carrega as classes e dependências

// Verifica se a opção de ordenação foi passada na URL, senão, define como 'desc' por padrão
$ordem = isset($_GET['ordem']) && $_GET['ordem'] == 'asc' ? 'asc' : 'desc';

// Consulta todos os livros, ordenando pela soma das avaliações, conforme a direção escolhida
$conexao = new MySQL();
$sql = "
    SELECT livro.idLivro, livro.nomeLivro, livro.imagemLivro, 
           COALESCE(SUM(ranking.avaliaçao), 0) AS totalAvaliacoes
    FROM livro
    LEFT JOIN ranking ON livro.idLivro = ranking.idDoLivro
    GROUP BY livro.idLivro
    ORDER BY totalAvaliacoes {$ordem}
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

<!-- Formulário para escolher a ordem de classificação -->
<form method="get" action="visualizarRanking.php">
    <label for="ordem">Ordenar por:</label>
    <select name="ordem" id="ordem" onchange="this.form.submit()">
        <option value="desc" <?php echo $ordem == 'desc' ? 'selected' : ''; ?>>Maior para Menor</option>
        <option value="asc" <?php echo $ordem == 'asc' ? 'selected' : ''; ?>>Menor para Maior</option>
    </select>
</form>

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
