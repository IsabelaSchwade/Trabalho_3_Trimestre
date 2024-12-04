<?php
if(isset($_POST['botao'])){ // verifica se o formulário foi enviado
    require_once __DIR__."/vendor/autoload.php";

    // Verificar se o arquivo foi enviado corretamente
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        $nomeArquivo = $_FILES['imagem']['name'];
        $pastaDestino = 'uploads/'; // Pasta onde as imagens serão armazenadas
        $caminhoCompleto = $pastaDestino . basename($nomeArquivo);

        // Move o arquivo enviado para a pasta destino
        if(move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)){
            // Criar nova instância de Livro com os dados do formulário
            $livro = new Livro($_POST['nome'], $caminhoCompleto);
            $livro->save(); // Salva os dados no banco
            header("location: visualizarLivro.php"); // Redireciona para a página de visualização
            exit();
        } else {
            echo "Erro ao salvar a imagem.";
        }
    } else {
        echo "Erro no upload da imagem.";
    }
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
    <form action='formAddLivro.php' method='POST' enctype="multipart/form-data">
        Nome do livro: <input name='nome' type='text' required>
        <br>
        <label>Foto da capa do livro:</label>
        <input type="file" id="imagem" name="imagem" accept="image/*" required>
        <br>
        <input type='submit' name='botao' value='Adicionar'>
    </form>

    <a href='visualizarRanking.php'>Voltar</a>
</body>
</html>
