<?php
require_once __DIR__ . "/vendor/autoload.php"; 
$ordem = isset($_GET['ordem']) && $_GET['ordem'] == 'asc' ? 'asc' : 'desc';

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
    <link rel='stylesheet' type='text/css' href='1.css'>
    <title>Ranking dos Livros</title>
</head>
<body>
<h1>Ranking de Livros &#10084;&#65039; &#x1F4D6;</h1>


<form method="get" action="visualizarRankingUsuario.php">
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
            <th>Capa</th>
            <th> Opções </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $posicao = 1; 
        foreach ($livros as $livro) {
            echo "<tr>";
            echo "<td>{$posicao}º</td>"; 
            echo "<td>{$livro['nomeLivro']}</td>";
            echo "<td><img src='{$livro['imagemLivro']}' alt='Imagem de {$livro['nomeLivro']}' width='100' height='150'></td>";
            echo "<td> <a href='VisualizarLivroUsuario.php?idLivro={$livro['idLivro']}'>Visualizar</a>
                  </td>";
            echo "</tr>";
            $posicao++;
        }
        ?>
    </tbody>
</table>
<div class="center-div">
<a href='logout.php' class="logout-btn">Sair</a>
    </div>
</body>
</html>