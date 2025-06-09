<?php
session_start();
session_unset(); // Limpa todas as variáveis de sessão
session_destroy();

header("Location: login.php");
exit();
