<?php
require_once __DIR__ . "/vendor/autoload.php";

if (isset($_GET['idLivro'])) {
    $idLivro = $_GET['idLivro'];
    $livro = Livro::find($idLivro);


// Nome do cookie baseado no ID do livro
$cookieName = "avaliacao_{$idLivro}";

// Verifica se o usuário já avaliou o livro com base no cookie
if (isset($_COOKIE[$cookieName])) {
    echo "<p>Você já avaliou este livro!</p>";
} else {
    // Verifica se o formulário foi enviado
    if (isset($_POST['avaliacao'])) {
        $avaliacao = $_POST['avaliacao'];

        // Verifica se a avaliação já existe no banco de dados
        require_once __DIR__ . "/src/Ranking.php";
        $ranking = new Ranking($livro->getIdLivro(), (int)$avaliacao);

        // Se a avaliação já foi salva para esse livro, exibe a mensagem
        if ($ranking->save()) {
            // Salva o cookie para garantir que o usuário não possa avaliar novamente
            setcookie($cookieName, "avaliado", time() + (86400 * 30), "/"); // 30 dias de validade
            header("Location: visualizarRanking.php?idLivro={$livro->getIdLivro()}");
            exit();
        } else {
            // Caso a avaliação já tenha sido feita, exibe a mensagem de erro
            echo "<p>Erro ao salvar a avaliação. Talvez você já tenha avaliado este livro.</p>";
        }
    } 
}
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
        