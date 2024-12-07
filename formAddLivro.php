

<?php
if(isset($_POST['botao'])){ 
    require_once _DIR_."/vendor/autoload.php";

    
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        $nomeArquivo = $_FILES['imagem']['name'];
        $pastaDestino = 'uploads/'; 
        $caminhoCompleto = $pastaDestino . basename($nomeArquivo);

        
        if(move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)){
            
            $livro = new Livro($_POST['nome'], $caminhoCompleto);
            $livro->save(); // Salva os dados no banco
            header("location: visualizarLivro.php"); 
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
