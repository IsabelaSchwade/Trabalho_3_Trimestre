<?php
if(isset($_POST['botao'])){ // verifica se o formulario foi enviado
    require_once __DIR__."/vendor/autoload.php";
    $livro = new Livro($_POST['nome'],$_POST['imagem']); 
    // cria uma nova instancia da classe festa com os dados enviados pelo formulario. esses dados são passados como parametros para o construtor da classe festa
    $livro->save(); // chama o metodo save da classe festa para salvar os dados no banco
    header("location: visualizarLivro.php"); // volta para o index
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adiciona Livro</title>
</head>
<body>
    <form action='formAddLivro.php' method='POST'>
        Nome do livro: <input name='nome' type='text' required>
        <br>
        <label>Foto da capa do livro:</label>
        <input type="file" id="imagem" name="imagem" accept="image/*">
        <input type='submit' name='botao'>
    </form>
</body>
</html>