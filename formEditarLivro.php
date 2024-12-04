<?php
if(isset($_GET['idLivro'])){ // ve se o id esta definido
    require_once __DIR__."/vendor/autoload.php";
    $livro = Livro::find($_GET['idLivro']); 
    // recupera a festa referente ao id fornecido e armazena na variavel $festa
    //utiliza o metodo find para buscar no banco de dados a festa com o id espeificado
    // como busca só um é usado o find
}
if(isset($_POST['botao'])){
    require_once __DIR__."/vendor/autoload.php";
    $livro = new Livro($_POST['nome'],$_POST['imagem']); // cria uma nova insatancia da classe festa com os novos dados que foram enviados pelo formulario
    $livro->setIdLivro($_POST['idLivro']); // garante que a festa que vai ser atualizada é do mesmo id da festa selecionada
    $livro->save(); // salva os dados no banco
    header("location: visualizarRanking.php"); 
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
    <form action='formEditarLivro.php' method='POST'>
        <?php
            echo "Nome do livro: <input name='nome' value='{$livro->getNomeLivro()}' type='text' required>"; // preecnhe com o atual valor de nome
            echo "<br>";
            echo " <input name='imagem' value={$livro->getimagemLivro()}  required>";
            echo "<br>";
            echo "<input name='idLivro' value={$livro->getIdLivro()} type='hidden'>";
        ?>
        <br>
        <input type='submit' name='botao'>
    </form>
</body>
</html>
