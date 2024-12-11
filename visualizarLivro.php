<?php
require_once __DIR__ . "/vendor/autoload.php";

if (isset($_GET['idLivro'])) {
    $idLivro = (int)$_GET['idLivro'];
    $livro = Livro::find($idLivro);

  
    if (isset($_POST['avaliacao']) && isset($_POST['email'])) {
        $avaliacao = (int)$_POST['avaliacao'];
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if (!$email) {
            echo "<p>E-mail inválido. Tente novamente.</p>";
        } else {
           
            $ranking = new Ranking($livro->getIdLivro(), $avaliacao, $email);

          
            if ($ranking->save()) {
                echo "<p>Avaliação salva com sucesso!</p>";
                
                header("Location: visualizarRanking.php");  
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
    <link rel='stylesheet' type='text/css' href='1.css'>
    <title>Visualizar Livro</title>
</head>
<body>
   
 
        
        <div class="book-cover">
    <h1><?php echo $livro->getNomeLivro(); ?></h1>
    <img src="<?php echo $livro->getImagemLivro(); ?>" alt="Imagem de <?php echo $livro->getNomeLivro(); ?>" width="200" height="300">
</div>
    </div>

    <h3>Avalie este livro</h3>
    <form method="POST" action="visualizarLivro.php?idLivro=<?php echo $livro->getIdLivro(); ?>"> 
    
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

    <div class="center-div">
    <p><a href='visualizarRankingUsuario.php'  class="logout-btn">Voltar à lista de livros</a></p>
    <br>
<a href='logout.php' class="logout-btn">Sair</a>
    </div>
</html>