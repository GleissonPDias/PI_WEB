<?php
session_start();
session_unset(); // Limpa todas as variáveis de sessão
session_destroy(); // Destroi a sessão

header("Location: login.php"); // Redireciona para a tela de login
exit();
