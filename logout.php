<?php
session_start();

// Destroi a sessão e redireciona para a página de login
if (isset($_SESSION['usuario'])) {
    session_unset();
    session_destroy();
}

header("Location: login.php");
exit();
?>
