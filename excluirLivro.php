<?php
require_once __DIR__."/vendor/autoload.php";
$livro = Livro::find($_GET['idLivro']); // busca a festa fornecida pelo id atraves do get
// recupera a festa referente ao id fornecido e armazena na variavel $festa
    //utiliza o metodo find para buscar no banco de dados a festa com o id espeificado
    // como busca só um é usado o find

$livro->delete(); // executa o metodo delete da classe festa
header("location: visualizarLivro.php");

?>