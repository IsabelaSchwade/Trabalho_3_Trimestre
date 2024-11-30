<?php
require_once __DIR__ . "/vendor/autoload.php"; // Carrega as classes e dependências

// Verifica se o parâmetro idLivro foi passado na URL
if (isset($_GET['idLivro'])) {
    $idLivro = $_GET['idLivro']; // Recupera o id do livro da URL
    $livro = Livro::find($idLivro); // Encontra o livro pelo ID
    if (!$livro) {
        die("Livro não encontrado.");
    }
} else {
    die("ID do livro não especificado.");
}

// Verifica se a avaliação foi enviada via POST
if (isset($_POST['avaliacao'])) {
    // Recupera a avaliação selecionada
    $avaliacao = $_POST['avaliacao'];

    // Certifique-se de que a classe Ranking está corretamente carregada
    require_once __DIR__ . "/src/Ranking.php"; 

    // Corrigindo a criação do objeto Ranking
    $ranking = new Ranking($livro->getIdLivro(), $avaliacao); // Passa os dois parâmetros necessários
    $ranking->save(); // Salva a avaliação no banco

    // Redireciona para a página de visualização após salvar a avaliação
    header("Location: visualizarLivro.php?idLivro={$livro->getIdLivro()}");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Livro</title>
</head>
<body>
    <h1>Detalhes do Livro</h1>
    <!-- Exibe as informações do livro -->
    <div>
        <h2><?php echo $livro->getNomeLivro(); ?></h2>
        <img src="<?php echo $livro->getImagemLivro(); ?>" alt="Imagem de <?php echo $livro->getNomeLivro(); ?>" width="200" height="300">
    </div>

    <h3>Avalie este livro</h3>
    <form method="POST" action="visualizarLivro.php?idLivro=<?php echo $livro->getIdLivro(); ?>">
        <div class="star-rating">
            <?php
            // Cria os botões de estrelas para avaliação
            for ($i = 5; $i >= 1; $i--) {
                echo "<input type='radio' id='estrela{$i}' name='avaliacao' value='{$i}' required> <label for='estrela{$i}'>★</label>";
            }
            ?>
        </div>
        <br>
        <button type="submit">Avaliar</button>
    </form>

    <p><a href="visualizarRanking.php">Voltar à lista de livros</a></p>
</body>
</html>
