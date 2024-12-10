<?php
require_once __DIR__ . "/vendor/autoload.php";

if (isset($_GET['idLivro'])) {
    $idLivro = (int)$_GET['idLivro'];
    $livro = Livro::find($idLivro);

    // Verifica se o formulário foi enviado
    if (isset($_POST['avaliacao']) && isset($_POST['email'])) {
        $avaliacao = (int)$_POST['avaliacao'];
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if (!$email) {
            echo "<p>E-mail inválido. Tente novamente.</p>";
        } else {
            // Cria a instância de Ranking com o e-mail do usuário
            $ranking = new Ranking($livro->getIdLivro(), $avaliacao, $email);

            // Tenta salvar a avaliação
            if ($ranking->save()) {
                echo "<p>Avaliação salva com sucesso!</p>";
                // Redireciona para evitar reenvio do formulário
                header("Location: visualizarRankingUsuario.php");
                exit();
            } else {
                echo "<p>Você já avaliou este livro com este e-mail.</p>";
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
    <link rel='stylesheet' type='text/css' href='style.css'>
    <title>Visualizar Livro</title>
</head>
<body>
    <h1>Detalhes do Livro</h1>
    <div>
        <h2><?php echo $livro->getNomeLivro(); ?></h2>
        <img src="<?php echo $livro->getImagemLivro(); ?>" alt="Imagem de <?php echo $livro->getNomeLivro(); ?>" width="200" height="300">
    </div>

    <h3>Avalie este livro</h3>
    <form method="POST" action="visualizarLivroUsuario.php?idLivro=<?php echo $livro->getIdLivro(); ?>">
        <div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="star-rating">
            <?php
            for ($i = 5; $i >= 1; $i--) {
                echo "<input type='radio' id='estrela{$i}' name='avaliacao' value='{$i}' required> 
                      <label for='estrela{$i}'>★</label>";
            }
            ?>
        </div>
        <br>
        <button type="submit">Avaliar</button>
    </form>

    <p><a href="visualizarRankingUsuario.php">Voltar à lista de livros</a></p>
</body>
</html>