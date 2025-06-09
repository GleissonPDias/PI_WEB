<?php
session_start();

if(isset($_SESSION['mensagem_erro'])) {
    echo '<p style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; padding: 10px 15px; margin: 20px auto; max-width: 500px; text-align: center;">' . htmlspecialchars($_SESSION['mensagem_erro']) . '</p>';
    unset($_SESSION['mensagem_erro']); 
}
if(isset($_SESSION['mensagem_sucesso'])) {
    echo '<p style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; padding: 10px 15px; margin: 20px auto; max-width: 500px; text-align: center;">' . htmlspecialchars($_SESSION['mensagem_sucesso']) . '</p>';
    unset($_SESSION['mensagem_sucesso']); 
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <style>
        body {
            background-color: #f0f4f8; 
            display: flex; 
            justify-content: center; 
            align-items: flex-start; 
            padding: 50px 20px; 
            min-height: 100vh; 
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container { 
            background-color: #E9efff; 
            padding: 30px;
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.97); 
            width: 100%;
            max-width: 550px; 
        }

        h1 {
            color: #2c3e50; 
            margin-bottom: 30px;
            text-align: center; 
            font-size: 2.2em;
            font-weight: 700;
        }

        form {
            display: flex;
            flex-direction: column; 
        }

        form label {
            font-weight: 600; 
            color: #4a6c89; 
            margin-bottom: 5px; 
            margin-top: 15px;
            display: block; 
            text-align: left; 
        }

        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 12px 4px;
            border: 1px solid #cce7ed;
            border-radius: 8px; 
            font-size: 1.05em;
            color: #333;
            outline: none; 
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 0; 
            box-sizing: border-box;
        }

        form input[type="text"]:focus,
        form input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        form button[type="submit"] {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1.05em;
            cursor: pointer; 
            font-weight: 600;
            margin-top: 30px; 
            background-color: #007bff; 
            color: white;
            display: block; 
            margin-left: auto; 
            margin-right: auto; 
            width: 100%;
            transition: all 0.3s ease;
        }

        form button[type="submit"]:hover {
            background-color: white; 
            transform: translateY(-2px);
            border: 2px solid #007bff;
            color: #007bff;
        }

        .voltar-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .voltar-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Redefinição de Senha</h1>
        <form action="verifica_frase_seguranca.php" method="post">
            <label for="nome_usuario">Nome de Usuário:</label>
            <input type="text" id="nome_usuario" name="nome_usuario" required placeholder="Digite seu nome de usuário">
            
            <label for="frase_seguranca">Frase de Segurança:</label>
            <input type="text" id="frase_seguranca" name="frase_seguranca" required placeholder="Digite sua frase de segurança">
            
            <button type="submit">Verificar Frase</button>
            
            <a href="../login.php" class="voltar-link">← Voltar para Login</a>
        </form>
    </div>
</body>
</html>