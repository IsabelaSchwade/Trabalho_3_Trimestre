<?php
if (isset($_GET['idLivro'])) {
    require_once __DIR__ . "/vendor/autoload.php";
    $livro = Livro::find($_GET['idLivro']); 
}

if (isset($_POST['botao'])) { 
    require_once __DIR__ . "/vendor/autoload.php";

    // Recupera o livro para atualização
    $livro = Livro::find($_POST['idLivro']);
    $livro->setNomeLivro($_POST['nome']);

    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $nomeArquivo = $_FILES['imagem']['name'];
        $pastaDestino = 'uploads/'; 
        $caminhoCompleto = $pastaDestino . basename($nomeArquivo);

        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
            $livro->setImagemLivro($caminhoCompleto); 
        } else {
            echo "Erro ao salvar a nova imagem.";
            exit();
        }
    }

    $livro->save(); 
    header("location: visualizarRanking.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
</head>
<body>
    <h1> Editar Livro </h1>
    <br>
    <form action="formEditarLivro.php" method="POST" enctype="multipart/form-data">
        <?php
            echo "Nome do livro: <input name='nome' value='{$livro->getNomeLivro()}' type='text' required>";
            echo "<br>";
            echo "Imagem atual: <img src='{$livro->getImagemLivro()}' alt='Capa atual' width='100' height='150'>";
            echo "<br>";
            echo "<label>Alterar imagem:</label>";
            echo "<input type='file' id='imagem' name='imagem' accept='image/*'>";
            echo "<br>";
            echo "<input name='idLivro' value='{$livro->getIdLivro()}' type='hidden'>";
        ?>
        <br>
        <input type="submit" name="botao" value="Salvar">
    </form>

    <a href="visualizarRanking.php">Voltar</a>
</body>
</html>