

<?php
require_once __DIR__."/vendor/autoload.php";
$livro = Livro::find($_GET['idLivro']); 

$livro->delete(); 
header("location: visualizarRanking.php");

?>
